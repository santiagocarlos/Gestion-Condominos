<?php

namespace App\Http\Controllers;

use App\ArrearsInterests;
use App\Residential;
use Illuminate\Http\Request;

class ArrearsInterestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residential = Residential::get();
        return view('admin.config.indexPayConfiguration', compact('residential'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\arrears_interests  $arrears_interests
     * @return \Illuminate\Http\Response
     */
    public function show(ArrearsInterests $arrears_interests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\arrears_interests  $arrears_interests
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.config.editPaymentDeadline');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\arrears_interests  $arrears_interests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArrearsInterests $arrears_interests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\arrears_interests  $arrears_interests
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArrearsInterests $arrears_interests)
    {
        //
    }
}
