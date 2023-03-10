<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Color;
use App\Models\Colour;
use App\Models\Condition;
use App\Models\Product;
use App\Models\State;
use App\Models\Transmission;
use App\Models\Trim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    function create(Request $request){
        $input = $request->all();
        $rules = array(
            'state' => 'required',
            'category' => 'required',
            'maker' => 'required',
            'model' => 'required',
            'colour' => 'required',
            'year_of_production' => 'required',
            'transmission' => 'required',
            'condition' => 'required',
            'chasis_number' => 'required',
            'trim' => 'required',
            'description' => 'required',
            'price' => 'required',
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

        $pid['title']="Advt";
        $pid['slug']=uniqid();
        $pid['avatar']="";
        $pid['description']=$input['description'];
        $pid['category_id']=$input['category'];
        $pid['state_id']=$input['state'];
        $pid['make_id']=$input['maker'];
        $pid['model_id']=$input['model'];
        $pid['colour']=$input['colour'];
        $pid['condition']=$input['condition'];
        $pid['year_of_production']=$input['year_of_production'];
        $pid['transmission']=$input['transmission'];
        $pid['chasis_no']=$input['chasis_number'];
        $pid['trim']=$input['trim'];
        $pid['description']=$input['description'];
        $pid['price']=$input['price'];
        $pid['user_id']=Auth::id();
        Product::create($pid);

        return response()->json(['success' => 1, 'message' => 'Ad created successfully']);

    }

    function list(){

        $data=Product::where("status", 'active')->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function sponsored(){

        $data=Product::where(["status" => 'active', 'featured' => 1])->inRandomOrder()->limit(20)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function stateList(){

        $data=State::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function makerList(){
        $data=CarMake::get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function conditionList(){
        $data=Condition::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function transmissionList(){
        $data=Transmission::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function modelList(){
        $data=CarModel::get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function trimList(){
        $data=Trim::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function categoryList(){
        $data=Category::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    function colourList(){
        $data=Colour::where("status", 1)->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }
}
