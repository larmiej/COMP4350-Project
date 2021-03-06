<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Business\DataAccess;
use App\models\ClientList;
use App\models\users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientFormEditController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataAccess = new DataAccess();
        $id = $dataAccess->currentUserID();
        $patient = $dataAccess->getPatient($id);

        return \View::make('client_form')->with('patient',$patient);
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
        $dataAccess = new DataAccess();
        $id = $dataAccess->currentUserID();

        $patient = $dataAccess->getPatient($id);

        $list = [
            'userid' => $id,
            'firstName' => $patient["firstName"],
            'lastName' => $patient["lastName"],
            'dob' => "{$request->year}-{$request->month}-{$request->day}",
            'email' => $patient["email"],
            'gender' => $request->sex,
            'height' => $request->height,
            'weight' => $request->weight,
            'mobileNum' => $request->phone,
            'homeNum' => $request->home_phone,
            'address' => $request->address,
            'city' => $request->city,
            'postalCode' => $request->postal_code,
            'state' => $request->state,
            'country' => $request->country,
            'occupation' => $request->occupation,
            'maritalStatus' => $request->status,
            'nextOfKin' => $request->next_kin
        ];

        $dataAccess->clientInfoSave($list, Auth::user()->email);

        return redirect('home');
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
