<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Posts;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class blogsController extends Controller
{
    //show blog posts
    public function show_blogs()
    {
        $posts = DB::table('posts')->get();
        return view('welcome', ['blogs' => $posts]);
    }

    //select logged in user to update records
    public function select_post(Request $request)
    {
        //request user id from the uri
        $id = $request['id'];
        //checks if the user is currently logged in and redirect the user to login is user is not logged in 
        if (Auth::user()) {
            $post_details = DB::table('posts')->where('id', $id)->orderBy('id', 'desc')->get();
            return view('update_post', ['post_details' => $post_details]);
        }
        return redirect('login'); //redirects to login if user is not logged in
    }

    //method to update user details
    public function update_post(Request $request)
    {
        //checks if the user is currently logged in and redirect the user to login is user is not logged in 
        if (Auth::user()) {
            // validate form inputs
            $validatedData = $request->validate([
                'post_title' => ['required', 'string', 'max:200'],
                'post_content' => ['required', 'string', 'max:1000'],
                'id' => ['required']
            ]);

            // Request user inputs from the form
            $id = $request->input('id');
            //performs update of blog post
            $post = Posts::find($id);
            $post->title = $request->input('post_title');
            $post->content = $request->input('post_content');
            $post->save();

            return ('<script type="text/javascript">
                alert("Post content Updated Successfully!");
                window.location.href = "home";
                </script>');
        }
        return redirect('login'); //redirects to login if user is not logged in
    }
}
