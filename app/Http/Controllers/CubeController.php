<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Illuminate\Http\Request;

class CubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dice.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cube $cube
     * @return \Illuminate\Http\Response
     */
    public function show(Cube $cube)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cube $cube
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dice = Cube::findOrFail($id);
        return view('dice.edit', compact('dice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cube $cube
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cube $cube)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cube $cube
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cube $cube)
    {
        //
    }
}
