<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RatingResource;
use App\Models\Employee;

class RatingController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'delete', 'update']);
    }

    /**
     * (محتوى الجدول كامل) جميع التقييمات لجميع الدكاترة.
     */
    public function index()
    {

        $ratings = Rating::paginate(3);;
        return $this->apiResponse(RatingResource::collection($ratings), 'all ratings:', 200);
    }

    //جميع التقييمات التابعة لدكتور معين
    public function doctor_ratings_details(Request $request)

    {
        $doctor_ratings = Rating::where('employee_id', $request->doctor_id)->paginate(3);
        return $this->apiResponse(RatingResource::collection($doctor_ratings), 'all ratings:', 200);
    }

    /**
     *ادخال تقييم من قبل مريض وتخزينه
     */
    public function store(RatingRequest $request)
    {
        // التحقق من ان التقييم ل دكتور وليس لموظف اداري
        $emp = Employee::find($request->doctor_id);

        if ($emp->user->hasRole('doctor')) {
            Rating::create([
                'patient_id'   => Auth::id(),
                'employee_id'  => $request->doctor_id,
                'doctor_rate'  => $request->doctor_rate,
                'details'      => $request->details,
            ]);
            return $this->successResponse('Rating added successfully', 200);
        } else {
            return $this->errorResponse('Not a doctor', 404);
        }
    }

    /**
     * عرض تقييم واحد تم ادخاله من قبل مريض محدد.
     */
    public function show(string $id)
    {
        $rate = Rating::find($id);
        if ($rate)
            return $this->apiResponse(new RatingResource($rate), '', 200);

        return $this->errorResponse('Rating not found to show', 404);
    }

    /**
     * تحديث تقييم واحد تم ادخاله من قبل مريض
     */
    public function update(string $id, RatingRequest $request)
    {
        // بهالطريقة ما فيني مرر القيم الجديدة ببرامترات الطريقة
        // .. ما بيتعرف عليا..
        // طلع لازم ابعتن من انسومنيا بالشكل:
        // Body -> json   OR form URL encoded

        // التحقق ان التقييم ل دكتور وليس لموظف اداري
        $emp = Employee::find($request->doctor_id);
        $isDoctor = $emp->user->hasRole('doctor');

        $rate = Rating::find($id);
        if (!$rate)
            return $this->errorResponse('Rating not found to delete it', 404);

        //  يتم تعديل التقييم اذا كان :
        //  التقييم موجود و التقييم  لدكتور و الشخص الذي ضاف التقييم هو الذي يقوم بالتقييم
        if (Auth::id() == $rate->patient_id && $isDoctor) {
            $rate->update([
                'employee_id' => $request->doctor_id,
                'doctor_rate' => $request->doctor_rate,
                'details'    => $request->details,

            ]);
            return $this->apiResponse(new RatingResource($rate), 'Rating updated successfully', 200);
        } else
            return $this->errorResponse('Not authorized', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rate = Rating::find($id);
        if (!$rate)
            return $this->errorResponse('Rating not found to delete it', 404);

        //الحصول على رول الشخص الذي يريد الحذف، اذا كان ادمن فينو يحذف مباشرة
        $user = Auth::guard('sanctum')->user();
        $isAdmin = $user->hasRole('Admin');

        if ($isAdmin || $user->id == $rate->patient_id) {
            $rate->delete();
            return $this->apiResponse([], 'Rating deleted successfully', 200);
        } else
            return $this->errorResponse('Not authorized', 401);
    }
}
