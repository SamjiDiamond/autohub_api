<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data=Watchlist::where("user_id", Auth::id())->with('product')->get();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'product_id' => 'required',
        );

        $validator = Validator::make($input, $rules);

        if (!$validator->passes()) {
            return response()->json(['success' => 0, 'message' => implode(",", $validator->errors()->all())]);
        }

        $pcheck=Product::find($input['product_id']);

        if(!$pcheck){
            return response()->json(['success' => 0, 'message' => "Kindly use valid product ID"]);
        }

        $input['user_id']=Auth::id();

        Watchlist::create($input);

        return response()->json(['success' => 1, 'message' => 'Fetched successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data=Watchlist::where([["user_id", Auth::id()], ["id", $id]])->with('product')->first();

        return response()->json(['success' => 1, 'message' => 'Fetched successfully', 'data'=>$data]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $wcheck=Watchlist::where([["user_id", Auth::id()], ["id", $id]])->first();

        if(!$wcheck){
            return response()->json(['success' => 0, 'message' => "Watchlist not found"]);
        }

        $wcheck->delete();

        return response()->json(['success' => 1, 'message' => 'Deleted successfully']);
    }
}
