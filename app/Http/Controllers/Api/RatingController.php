<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Rating;
use App\Models\Patient;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        // $this->middleware(['auth:sanctum', 'permission:show-patientRatings'])->only(['index', 'show', 'doctor_ratings_details']);
        // $this->middleware(['auth:sanctum', 'permission:edit-rating'])->only(['store', 'update']);
        // $this->middleware(['auth:sanctum', 'permission:delete-rating'])->only('destroy');
    }

    public function index()
    {
        $ratings = Rating::query();
        return $this->paginateRatings($ratings, 'all ratings:');
    }
    
    public function getMyRatings(Request $request)
    {
        $user = $request->user();
        $myRatings = Rating::where('patient_id', $user->patient->id);
        return $this->paginateRatings($myRatings, 'My ratings:');
    }
    
    // All Ratings related to specific doctor
    public function doctorRatingsDetails(Request $request)
    {
        $doctorRatings = Rating::where('employee_id', $request->doctor_id);
        return $this->paginateRatings($doctorRatings, 'all ratings:');
    }
    
    protected function paginateRatings($query, $message)
    {
        $ratings = $query->paginate(3);
        return $this->apiResponse(RatingResource::collection($ratings), $message, 200);
    }

    /**
     *  All Ratings for all doctors (overall Rating table)
     */
    // public function index()
    // {
    //     $ratings = Rating::paginate(3);;
    //     return $this->apiResponse(RatingResource::collection($ratings), 'all ratings:', 200);
    // }

    // public function getMyRatings(Request $request)
    // {
    //     $user = $request->user();
    //     $myRatings = Rating::where('patient_id',$user->patient->id)->paginate(3);;
    //     return $this->apiResponse(RatingResource::collection($myRatings), 'My ratings:', 200);
    // }

    // // All Ratings related to specific doctor
    // public function doctorRatingsDetails(Request $request)
    // {
    //     $doctorRatings = Rating::where('employee_id', $request->doctor_id)->paginate(3);
    //     return $this->apiResponse(RatingResource::collection($doctorRatings), 'all ratings:', 200);
    // }

    /**
     * store patient rate for a doctor
     */
    public function store(RatingRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        // $user = $request->user();

        $patient_id = $user->patient->id;

        $hasCompletedAppointment = Patient::where('id', $patient_id)
            ->whereHas('appointments', function ($query) use ($request) {
                $query->where('status', 'completed')
                    ->where('doctor_id', $request->doctor_id)
                    ->whereBetween('appointment_date', [now()->subWeek(), now()]);
            })->exists();

        // check if the rate is for a doctor (not adminstrative employee)
        $emp = Employee::find($request->doctor_id);
        if ($emp->user->hasRole('doctor') && $hasCompletedAppointment) {
            Rating::create([
                'patient_id'   => $patient_id,
                'employee_id'  => $request->doctor_id,
                'doctor_rate'  => $request->doctor_rate,
                'details'      => $request->details,
            ]);
            return $this->successResponse('Rating added successfully', 200);
        } else {
            return $this->errorResponse('Not allowed..', 404);
        }
    }

    /**
     * view one rate
     */
    public function show(string $id)
    {
        $rate = Rating::find($id);
        if ($rate)
            return $this->apiResponse(new RatingResource($rate), '', 200);

        return $this->errorResponse('Rating not found to show', 404);
    }

    /**
     * update rate
     */
    public function update(string $id, RatingRequest $request)
    {
        // The parameters are sent from Insomnia as follows:
        // Body -> json   OR form URL encoded

        $user = Auth::guard('sanctum')->user();
        $patient_id = $user->patient->id;


        $emp = Employee::find($request->doctor_id);
        $isDoctor = $emp->user->hasRole('doctor');

        $rate = Rating::find($id);
        if (!$rate)
            return $this->errorResponse('Rating not found to delete it', 404);

        $hasCompletedAppointment = Patient::where('id', $patient_id)
            ->whereHas('appointments', function ($query) use ($request) {
                $query->where('status', 'completed')
                    ->where('doctor_id', $request->doctor_id)
                    ->whereBetween('appointment_date', [now()->subWeek(), now()]);
            })->exists();

        //  rate can be updated if:
        //  rate is exsists && rate is for doctor && rate is added by the same patient who wants to update.
        if ($patient_id == $rate->patient_id && $isDoctor &&  $hasCompletedAppointment) {
            $rate->update([
                'employee_id' => $request->doctor_id,
                'doctor_rate' => $request->doctor_rate,
                'details'    => $request->details,

            ]);
            return $this->apiResponse(new RatingResource($rate), 'Rating updated successfully', 200);
        } else
            return $this->errorResponse('Not allowed ..', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rate = Rating::find($id);
        if (!$rate)
            return $this->errorResponse('Rating not found to delete it', 404);

        // Get the roll of the person who wants to delete, if ADMIN ==> delete immediately
        $user = Auth::guard('sanctum')->user();
        $isAdmin = $user->hasRole('Admin');

        if ($isAdmin || $user->id == $rate->patient_id) {
            $rate->delete();
            return $this->apiResponse([], 'Rating deleted successfully', 200);
        } else
            return $this->errorResponse('Not authorized', 401);
    }
}
