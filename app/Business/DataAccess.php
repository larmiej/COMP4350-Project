<?php
/**
 * Created by PhpStorm.
 * User: johnlarmie
 * Date: 2016-02-20
 * Time: 1:34 PM
 */

namespace App\Business;

use Auth;
use App\models\ClientList;
use App\models\users;
use App\models\calendar;

class DataAccess{

    function getClientsFromUsers()
    {
        //get client list
        $users = users::all();
        $clients = [];

        foreach($users as $patient)
        {
            //check if the user is apatient
            if(!$patient["admin"])
                $clients[] = $patient;
        }

        return $clients;
    }

    function getPatient($userEmail)
    {
        if(Auth::user()->firstEdit)
        {
            return ClientList::where('email', '=', $userEmail)->firstOrFail();
        }
        else
        {
            return users::where('email','=', $userEmail)->firstOrFail();
        }
    }

    function clientInfoSave($list, $userEmail)
    {
        try {
            $clientCheck = ClientList::where('email', '=', $userEmail)->firstOrFail();
            ClientList::where('email', $userEmail)
                ->update($list);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $client = ClientList::firstOrCreate($list);

            //change auth::firstedit to true !!!

            $user = users::where('email', '=', $userEmail)->firstOrFail();
            $user->firstEdit = 1;
            $user->save();
        }
    }

    function eventSave($id, $title, $start, $end, $userEmail, $name)
    {
        $list = [
            'event_id' => $id,
            'title' => $title,
            'start_time' => $start,
            'end_time' => $end,
            'client_id' => $userEmail,
            'client_name' => $name
            ];

        try {

            $eventCheck = calendar::where('event_id', '=', $id)->firstOrFail();
            //update saved event if no fail
            calendar::where('event_id', $id)
                ->update($list);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){

            //create new event
            $event = calendar::firstOrCreate($list);

        }
    }
}
