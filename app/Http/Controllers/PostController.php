<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
class PostController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();
        if(count($posts) >0 ){
            return response()->json(['status' => 'success' , 'message' => 'wow! post found','data' => $posts],200);
        }else{
            return response()->json(['status' => 'failed' , 'message' => 'whoops! post not found']);
        }
    }



    public function store(Request $request)
    {
        $authUser = Auth::user();
        if($authUser){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description' => 'required'
            ]);
            if($validator->fails()){
                return response()->json(['status' => 'failed' , 'validattion_errors' => $validator->errors()]);
            }
            $data = $request->all();
            $data['user_id'] = auth()->id();
            $post = Post::create($data);
            if($post){
                return response()->json(['status' => 'success','message' => 'Post created successfully','data'=> $post]);
            }else{
                return response()->json(['status' => 'failed' , 'Whoops! Post created Failed']);
            }
        }else{
          return response()->json(['status' => 'failed' ,'message' => 'Un-authorized'],403);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
