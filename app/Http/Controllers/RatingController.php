<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct() { 
        $this->middleware('role:Admin')->only('destroy'); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = Rating::paginate(5);
        // $ratings = Rating::with(['doctor', 'patient'])->get();
        return view('ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
