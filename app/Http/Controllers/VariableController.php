<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variable;

class VariableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('variable.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $variable
     * @return \Illuminate\Http\Response
     */
    public function edit(Variable $id)
    {
        //$variable = Variable::find($id);
        return view('variable.edit', compact('id'));
    }
}
