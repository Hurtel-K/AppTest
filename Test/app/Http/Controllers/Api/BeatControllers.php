<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Beat;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;

class BeatControllers extends Controller
{


    public function listeBeats(Request $request){

        $validator = Validator::make($request->all(), [
            'page' => 'sometimes|numeric',
            'limit' => 'sometimes|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'messages' => ['errors' => $validator->errors()],
            ], 422);
        }
           $beat= Beat::latest()->paginate($request->limit ?? 3);

        if($beat)
        {
            return response()->json([
                "status" => 1,
                "message"=>"liste des Beats",
                "data" => $beat
            ],200);
        } else{
            return response()->json([
                "status" => 0,
                "message"=>"Aucune Beat en base de donné"
            ],404);

        }

        }



    public function getBeats($slug){


            //     $validator = Validator::make($request->all(), [
            //          'slug'=>'required'
            //    ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'messages' => ['errors' => $validator->errors()],
            //     ], 422);
            // }
            $beat= Beat::where('slug',$slug)->get();

            if($beat)
             {

                return response()->json([
                    "status" => 1,
                    "message"=>"beat trouver",
                    "data" => $beat
                ],200);
            } else{
                return response()->json([
                    "status" => 0,
                    "message"=>"Aucune beat trouve pour ce slug"
                ],404);

            }


    }
     public function searchBeat(Request $request)
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
            $beat= Beat::where('title','like','%' . $request->search . '%')->paginate($request->limit ?? 5);

            if($beat)
            {
                return response()->json([
                    "status" => 1,
                    "message"=>"Beat(s) trouvée(s)",
                    "data" => $beat
                ],200);
            } else{
                return response()->json([
                    "status" => 0,
                    "message"=>"Aucun beat trouvée pour cette recherche"
                ],404);

            }

        }


    public function createBeat(Request $request){

    $validator = Validator::make($request->all(), [
        'title'=>'required',
        'slug'=> 'required|unique:beats',
        'audio_file'=>'required|file'
        // |mimes:audio/mpeg,audio/wav,max:2048
        // $audioName = time().'.'.$audio->getClientOriginalExtension();

    ]);
    if ($validator->fails()) {
        return response()->json([
            'messages' => ['errors' => $validator->errors()],
        ], 422);
    }

      $audioPath = $request->file('audio_file')->store('audios','public');

       $Beat = Beat::create([
        'title'=> $request->title,
        'slug' =>$request->slug,
        'audio_file'=>$audioPath

      ]);
      if($Beat){
        return response()->json([
            "status" => 1,
            "message"=>"Boutique cree",
            "data" => $Beat
        ],200);
    } else{
        return response()->json([
            "status" => 0,
            "message"=>"Echec de la creation"
        ],404);
      }

    }

    public function deleteBeat($uuid){


        //     $validator = Validator::make($request->all(), [
        //          'slug'=>'required'
        //    ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'messages' => ['errors' => $validator->errors()],
        //     ], 422);
        // }
        $beat= Beat::find($uuid)
        ;

        if($beat)
         {
            $beat->delete();
            return response()->json([
                "status" => 1,
                "message"=>"beat suprimmer",

            ],200);
        } else{
            return response()->json([
                "status" => 0,
                "message"=>"beat introuvable"
            ],404);

        }


}




}
