<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make($input, $rules);

        $input = $request->all();

        Log::info("Login endpoint: " . json_encode($input));

        if (!$validator->passes()) {

            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }

        $user = User::where('email', $input['email'])->first();
        if (!$user) {
            return response()->json(['success' => 0, 'message' => 'User does not exist']);
        }

        if (!Hash::check($input['password'], $user->password)) {
            return response()->json(['success' => 0, 'message' => 'Incorrect password attempt']);
        }

        $token = $user->createToken("admin")->plainTextToken;

        return response()->json(['success' => 1, 'message' => 'Login successfully', 'token' => $token]);
    }

    public function affiliateRegister(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'company_name' => 'required|min:4',
            'company_address' => 'required|min:9',
            'company_cac' => 'required|max:1',
            'company_nata' => 'required|max:1',
            'year_of_experience' => 'required',
            'specialization' => 'required',
            'name' => 'required|min:4',
            'password' => 'required|min:6',
            'phoneno' => 'required:unique:users',
            'email' => 'required|email|unique:users',
            'avatar' => 'nullable',
            'id_card_front' => 'required',
            'id_card_back' => 'required',
        );

        $messages = [
            'same' => 'The :attribute and :other must match.',
            'size' => 'The :attribute must be exactly :size.',
            'min' => 'The :attribute value :input is below :min',
            'unique' => 'The :input already exist',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if (!$validator->passes()) {
            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }

        //values gotten

        $create["type"] = "affiliate";
        $create["email"] = $input["email"];
        $create["name"] = $input["name"];
        $create["phoneno"] = $input["phoneno"];
        $create["password"] = Hash::make($input['password']);
        $create['year_of_experience']=$input["year_of_experience"];
        $create['specialization']=$input["specialization"];
        $create['id_card_front']=$input["id_card_front"];
        $user=User::create($create);

        $biz['user_id']=$user->id;
        $biz['name']=$input["company_name"];
        $biz['address']=$input["company_address"];
        $biz['cac']=$input["company_cac"];
        $biz['nata']=$input["company_nata"];

        if (Company::create($biz)) {
            // successfully inserted into database
            return response()->json(['success' => 1, 'message' => 'Account created successfully']);
        } else {
            return response()->json(['success' => 0, 'message' => 'Oops! An error occurred.']);
        }

    }
}
