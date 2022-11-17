<?php

namespace App\Http\Controllers;

use App\Jobs\VFDTestPaymentNotice;
use App\Models\GeneralSettings;
use App\Models\Brand;
use App\Models\HomeSlider;
use App\Models\State;
use App\Models\Category;
// use App\Models\GeneralSettings;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{

    // Home Functions Starts Here
    public function index(){
        $data['sliders'] = HomeSlider::all();
        $data['category'] = Category::where('status',1)->get();
        $data['brands'] = Brand::where('status',1)->get();
        $data['location'] = State::with('lgas')->get();
        $data['featured'] = [];
        $data['newly_added'] = [];
        $data['everything'] = [];
        $data['exhautic'] = [];

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function terms(){
        $data['page_title'] = "Terms and Conditions";
        return view('terms', $data);
    }

    // to simulate a test payment
    public function notice(){
        $data['page_title'] = "Terms and Conditions";
        return view('notice', $data);
    }

    public function sendNotice(Request $request){
        $request->validate([
            'bank' => 'required|string',
            'accountNo' => 'required|numeric',
            'amount' => 'required|numeric',
            'naration' => 'required|string',
            'pin' => 'required|numeric',
        //
        ], [
            'image.required' => 'Select Image to upload',
            'image.mimes' => 'Only jpeg,jpg,png,bmp Image supported',
        ]);

        if($request->bank != "vfd"){
            return back()->with(['error'=>"Only VFD Bank is Available for test payment at the moment"]);
        }

        $pin = substr($request->accountNo, -4);

        if($request->pin != $pin){
            return back()->with(['error'=>"Incorrect Pin Provided"]);
        }

        // check if account exist
        $acc = User::where('account_two',$request->accountNo)->first();
        if(!$acc){
            return back()->with(['error'=>"Account does not exist on XtraPay"]);
        }

        // VFDTestPaymentNotice::dispatch($request->amount,$request->accountNo,$request->naration);

        $ref = "Vfd-x-" . rand();
        $sessionId = "0000".$pin.Carbon::now()->format('YmdHi');

        // $payload = '{
        //     "reference": "' . $ref . '",
        //     "amount": "' . $request->amount . '",
        //     "account_number": "' . $request->accountNo . '",
        //     "originator_account_number": "0000001234",
        //     "originator_account_name": "XtraPay",
        //     "originator_bank": "999999",
        //     "originator_narration": "' . $request->naration . '",
        //     "timestamp": "' . Carbon::now() . '",
        //     "sessionId": "' . $sessionId . '"
        //   }';

          $payload['reference'] = $ref;
          $payload['amount'] = $request->amount;
          $payload['account_number'] = $request->accountNo;
          $payload['originator_account_number'] = "0000001234";
          $payload['originator_account_name'] = "XtraPay";
          $payload['originator_bank'] = "999999";
          $payload['originator_narration'] = $request->naration;
          $payload['timestamp'] = Carbon::now();
          $payload['sessionId'] = $sessionId;

          $data = json_encode($payload);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://xtrapay.techplushost.com/api/vfd-vaccount-webhook',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return back()->with(['status'=>"Test Payment Sent to your Account Successfully"]);
    }
}
