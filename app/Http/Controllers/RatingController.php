<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // public function __construct() {
    //     $this->middleware('role:Admin')->only('destroy');
    // }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show-rating', ['only' => ['index']]);
        $this->middleware('permission:delete-rating', ['only' => ['destroy']]);

    }
 
    /**
     * Display a listing of the ratings.
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
     * Display the specified rating.
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * permanent delete rating info
     * @param \App\Models\Rating $rating
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index');
    }
}
