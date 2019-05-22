<?php

namespace App\Http\Controllers;

use App\ArrearsInterests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $defaulters = ArrearsInterests::join('billing_notices', 'arrears_interests.billing_notice_id', '=', 'billing_notices.id')
                        ->join('apartments', 'billing_notices.apartment_id', '=', 'apartments.id')
                        ->join('towers', 'apartments.tower_id', '=', 'towers.id')
                        ->join('owners', 'apartments.id', '=', 'owners.apartment_id')
                        ->join('users', 'owners.user_id', '=', 'users.id')
                        ->join('peoples', 'users.people_id', '=', 'peoples.id')
                        ->select(
                            'peoples.ci',
                            'peoples.name',
                            'peoples.last_name',
                            'towers.name as towerName',
                            'apartments.floor',
                            'apartments.apartment',
                            'billing_notices.nro',
                            'billing_notices.amount',
                            'billing_notices.date',
                            DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge')
                        )
                        ->where('owners.status', '=', 1)
                        ->get();

        return view('admin.defaulters.index', compact('defaulters'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
