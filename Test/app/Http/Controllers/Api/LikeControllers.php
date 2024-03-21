<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikeControllers extends Controller
{
    public function like(Request $request ,$uuid){

        $validator = Validator::make($request->all(), [
            'like'=>'required',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => ['errors' => $validator->errors()],
            ], 422);
        }
         $beat= Beat::where('id',$uuid);

         $like = Like::Where('likeable_id',$beat)
                     ->first();

        if($like){
            $like->delete();
            return response()->json([
                "status" => 0,
                "message"=>"tu as deliker "
            ],200);
        } else{

            $like = new Like();
            $like->like = $request->like;
          


            if( $beat->likes()->save($like)){
            return response()->json([
                "status" => 1,
                "message"=>"like effectuer",
                "like" =>$like
            ],201);
        }  else{

            return response()->json([
                "status" => 0,
                "message"=>" une erreur c'est produitessayez plus tard"
            ],500);
            }
        }





        }
}
