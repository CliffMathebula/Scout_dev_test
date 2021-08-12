<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Posts;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class blogsController extends Controller
{
    //show blog posts
    public function show_blogs()
    {
        $posts = DB::table('posts')->get();
        return view('welcome', ['blogs' => $posts]);
    }

    public function select_post(Request $request)
    {
        
        $user_id = Auth::id();
        $author_id = $request['auth_id'];

        if (Auth::user() && $user_id === $author_id) { //select logged in user to update records
        
        $id = $request['id']; //gets user id
        
            $post_details = DB::table('posts')->where('id', $id)->orderBy('id', 'desc')->get();
            return view('update_post', ['post_details' => $post_details]);
        }
        return ('<script type="text/javascript">
                alert("This Post Belongs to Another user!");
                window.location.href = "/";
                </script>');
    }

    //method to update post details
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


    //return view 
    public function blog_post(Request $request)
    {
        $user_id = Auth::id();
        $author_id = $request['auth_id'];

        if (Auth::user() && $user_id === $author_id) {
            return view('add_post'); //redirects to login if user is not logged in     
        }else{
            return ('<script type="text/javascript">
                alert("This Post Belongs to Another user!");
                window.location.href = "/";
                </script>');
        }
    }

    public function create_post(Request $request)
    {
        if (Auth::user()) {
            // validate form inputs
            $validatedData = $request->validate([
                'post_title' => ['required', 'string', 'max:200'],
                'post_content' => ['required', 'string', 'max:1000']
            ]);

            $author_id = Auth::id();

            $date = date('Y-m-d h:i:sa');

            if (
                Posts::create([
                    'author_id' => $author_id,
                    'title' => $request['post_title'],
                    'content' => $request['post_content']
                ])
            ) {


                return ('<script type="text/javascript">
                alert("Post Created Successfully!");
                window.location.href = "home";
                </script>');
            } else
                return ('<script type="text/javascript">
                alert("Failed to create post");
                window.location.href = "post_blog";
                </script>');
        }
        return redirect('login'); //redirects to login if user is not logged in

    }

    public function destroy(Request $request) //delete post for current logged in user
    {
        $user_id = Auth::id();
        $author_id = $request['auth_id'];

        if (Auth::user() && $user_id === $author_id) {
            $post_id = $request['post_id'];

            DB::delete('delete from posts where id = ?', [$post_id]);

            return ('<script type="text/javascript">
                alert("Post deleted successfully");
                window.location.href = "/";
                </script>');
        }
        return ('<script type="text/javascript">
                alert("Failed to Delete Post, Post Belongs to another User");
                window.location.href = "/";
                </script>');
    }

    public function rate_post(Request $request) //delete post for current logged in user
    {
        //ggets values 
        $post_id = $request['post_id'];
        $rates = $request['rate_value'];
        $old_rates = $request['rate'];
        $total_rates = $rates + $old_rates;

        //performs update of blog post
        $post = Posts::find($post_id);
        $post->rates = $total_rates;
        $post->save();

        return ('<script type="text/javascript">
                        alert("Post content Updated Successfully!");
                        window.location.href = "/";
                        </script>');
    }
}
