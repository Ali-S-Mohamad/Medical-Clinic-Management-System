<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-rating', ['only' => ['index']]);
        $this->middleware('permission:delete-rating', ['only' => ['destroy']]);

    } 
    /**
     *  Display a listing of ratings.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ratings = Rating::paginate(5);
        // $ratings = Rating::with(['doctor.user', 'patient.user'])->paginate(5);
        // $ratings = Rating::with(['doctor', 'patient'])->get();
        return view('ratings.index', compact('ratings'));
    }
    /**
     *  Display the specified resource.
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\Rating $rating
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index');
    }
}
