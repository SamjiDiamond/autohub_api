<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function profile(){
        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>Auth::user()]);
    }

    function updateProfile(Request $request){

        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'phoneno' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if (!$validator->passes()) {
            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }


        $input = $request->all();

        $user=User::find(Auth::id());
        $user->name=$input['name'];
        $user->phoneno=$input['phoneno'];
        $user->save();

        $user->refresh();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$user]);
    }

    function changePassword(Request $request){

        $input = $request->all();
        $rules = array(
            'currentPassword' => 'required',
            'newPassword' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if (!$validator->passes()) {
            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }


        $input = $request->all();


        if(!Hash::check($input['currentPassword'], Auth::user()->password)){
            return response()->json(['success' => 0, 'message' => 'Incorrect current password']);
        }

        $user=User::find(Auth::id());
        $user->password=Hash::make($input['newPassword']);
        $user->save();

        return response()->json(['success' => 1, 'message' => 'Password changed successfully']);
    }

    function updateAvatar(Request $request){

        $input = $request->all();
        $rules = array(
            'avatar' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if (!$validator->passes()) {
            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }


        $input = $request->all();

        $user=User::find(Auth::id());
        $user->
        $user->save();


        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$user]);
    }

}
