<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;

class PersonController extends Controller
{
    public function getInfo()
    {

        $person = DB::table('people')->find(10);
        // dd($person);
        return $person;
    }
}