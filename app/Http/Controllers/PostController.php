<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Category;
use App\Http\Services\RatingsService;
use App\Http\Services\TagsService;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all Posts, ordered by the newest first
        $posts = Post::latest()->get();

        // Pass Post Collection to view
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show create post for
        $categories = Category::all();
        return view('posts.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate posted form data
        $validated = $request->validate([
            'title' => 'required|string|unique:posts|min:5|max:100',
            'content' => 'required|string|min:5|max:2000',
            'category' => 'required|string|max:30',
            'price' => 'required|numeric|max:10000'
        ]);

        // Create slug from title
        $validated['slug'] = Str::slug($validated['title'], '-');
        $validated['user_id'] = Auth::id();

        // Create and save post with validated data
        $post = Post::create($validated);
        //Gaunam tagus ir juos issaugom
        $ts = new TagsService();
        $ts->SaveTags($post->id, $request->input('tags'));

        // Redirect the user to the created post with a success notification
        return redirect(route('posts.show', [$post->slug]))->with('notification', 'Post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $post = Post::where('slug', $post)->first();
        if(!$post) abort(404);
        $rate = RatingsService::overall($post->id);
        // Pass current post to view
        return view('posts.show', [
            'post' => $post,
            'rate' => $rate
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        $post = Post::where('slug', $post)->first();
        if($post->user_id == Auth::id()) {
            $categories = Category::all();
            return view('posts.edit', [
                'post' => $post,
                'categories' => $categories
            ]);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post)
    {
        $post = Post::where('slug', $post)->first();
        if($post->user_id == Auth::id()) {
            // Validate posted form data
            $validated = $request->validate([
                'title' => 'required|string|min:5|max:100',
                'content' => 'required|string|min:5|max:2000',
                'category' => 'required|string|max:30',
                'price' => 'required|numeric|max:10000'
            ]);

            // Create slug from title
            $validated['slug'] = Str::slug($validated['title'], '-');

            // Update Post with validated data
            $post->update($validated);

            $ts = new TagsService();
            $ts->UpdateTags($post->id, $request->input('tags'));

            // Redirect the user to the created post woth an updated notification
            return redirect(route('posts.show', [$post->slug]))->with('notification', 'Post updated!');
        }else return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        $post = Post::where('slug', $post)->first();
        if($post->user_id == Auth::id()) {
            // Delete the specified Post
            $post->delete();
            $rs = new RatingsService();
            $ts = new TagsService();
            $rs->RemoveAll($post->id);
            $ts->RemoveAll($post->id);
            Bookmark::where('post', $post->id)->delete();

            // Redirect user with a deleted notification
            return redirect(route('home'));
        }else{
            return redirect()->back();
        }
    }
}
