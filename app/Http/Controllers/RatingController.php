<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-rating', ['only' => ['index']]);
        $this->middleware('permission:delete-rating', ['only' => ['destroy']]);

    } 
    /**
     * Display a listing of ratings.
     *
     * @return void
     */
    public function index()
    {
        $ratings = Rating::paginate(5);
        // $ratings = Rating::with(['doctor.user', 'patient.user'])->paginate(5);
        // $ratings = Rating::with(['doctor', 'patient'])->get();
        return view('ratings.index', compact('ratings'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index');
    }
}
