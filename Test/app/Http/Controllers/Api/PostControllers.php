<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostControllers extends Controller
{


    public function listePost(Request $request){

        $validator = Validator::make($request->all(), [
            'page' => 'sometimes|numeric',
            'limit' => 'sometimes|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => ['errors' => $validator->errors()],
            ], 422);
        }
           $post= Post::where('is_published',true)->latest()->paginate($request->limit);

        if($post)
        {
            return response()->json([
                "status" => 1,
                "message"=>"liste des posts",
                "data" => $post
            ],200);
        } else{
            return response()->json([
                "status" => 0,
                "message"=>"Aucune Beat en base de donné"
            ],404);

        }

        }



           public function getPost($id){


            $post= Post::find($id);

            if($post)
             {

                return response()->json([
                    "status" => 1,
                    "message"=>"beat trouver",
                    "data" => $post
                ],200);
            } else{
                return response()->json([
                    "status" => 0,
                    "message"=>"Aucune post trouve pour ce slug"
                ],404);

            }


    }
     public function searchPost(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'search'=>'required',
                'page' => 'sometimes|numeric',
                'limit' => 'sometimes|numeric'
        ]);

        if ($validator->fails()) {
        return response()->json([
            'messages' => ['errors' => $validator->errors()],
        ], 422);
        }
            $post= Post::where('description','like','%' . $request->search . '%')
                      ->where('is_published',true)
                      ->paginate($request->limit);

            if($post)
            {
                return response()->json([
                    "status" => 1,
                    "message"=>"Beat(s) trouvée(s)",
                    "data" => $post
                ],200);
            } else{
                return response()->json([
                    "status" => 0,
                    "message"=>"Aucun beat trouvée pour cette recherche"
                ],404);

            }

        }


    public function createPost(Request $request){

    $validator = Validator::make($request->all(), [
        'description'=>'required',
        'image_file'=>'required|file|mimes:jpg,png,jpeg'


    ]);
    if ($validator->fails()) {
        return response()->json([
            'messages' => ['errors' => $validator->errors()],
        ], 422);
    }

      $imagePath = $request->file('image_file')->store('image','public');

       $post = Post::create([
        'description'=> $request->description,
        'is_published' => true,
        'image_file'=>$imagePath

      ]);
      if($post){
        return response()->json([
            "status" => 1,
            "message"=>"post cree",
            "data" => $post
        ],200);
    } else{
        return response()->json([
            "status" => 0,
            "message"=>"Echec de la creation"
        ],404);
      }

    }


    public function deletePost($uuid){


        $post= Post::find($uuid);

        if($post)
         {
            $post->delete();
            return response()->json([
                "status" => 1,
                "message"=>"post suprimmer",

            ],200);
        } else{
            return response()->json([
                "status" => 0,
                "message"=>"post introuvable"
            ],404);

        }


}


}
