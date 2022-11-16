<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\RefBonus;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{
    //======================================================================
    // Providus HOOK STARTS HERE
    //======================================================================

    // Providus HOOK - INCOMING DEPOSIT (Transfer)
    public function webhook(Request $request){
        $input = $request->all();
        Log::info("Incoming deposit on Providus received. Details: ". json_encode($input));

        // check for user if belongs to user
        // else check for pos if belongs to pos

        return response()->json(['ok' => true, 200]);
    }


    //======================================================================
    // Providus HOOK ENDS HERE
    //======================================================================

}
