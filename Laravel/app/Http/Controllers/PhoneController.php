<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{

    public function show($id)
    {
        $phone = Phone::find($id);
        
        return response()->json([
            'success' => true,
            'data' => $phone
        ]);
    }
}
