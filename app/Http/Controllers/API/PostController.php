<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Http\Requests\PostRequest;
use App\Http\Services\RatingsService;
use App\Http\Services\TagsService;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostController extends BaseController
{
    protected TagsService $tagsService;
    protected RatingsService $ratingsService;

    public function __construct(TagsService $tagsService, RatingsService $ratingsService)
    {
        $this->tagsService = $tagsService;
        $this->ratingsService = $ratingsService;
    }

    public function index()
    {
        $posts = Post::latest()->get();

        return $this->return(compact('posts'));
    }

    public function store(PostRequest $request): JsonResponse
    {
        $file = $request->file('img');
        $destinationPath = 'assets/img/posts';
        $file->move($destinationPath, $file->getClientOriginalName());
        $img = '/'.$destinationPath.'/'.$file->getClientOriginalName();
        $request['img'] = $img;

        // Create slug from title
        $request['slug'] = Str::slug($request['title'], '-');
        $request['user_id'] = Auth::id();

        // Create and save post with validated data
        $post = Post::create($request);
        //Gaunam tagus ir juos issaugom
        $this->tagsService->saveTags($post->id, $request->input('tags'));

        // Redirect the user to the created post with a success notification
        return $this->return(['success' => 'Post created!'], Response::HTTP_CREATED);
    }

    public function show(Post $post): JsonResponse
    {
        $post = Post::where('slug', $post)->first();

        $rate = RatingsService::overall($post->id);

        return $this->return(compact('post', 'rate'));
    }

    public function update(PostRequest $request, $post): JsonResponse
    {
        $post = Post::where('slug', $post)->first();
        if ($post->user_id == Auth::id()) {
            if ($request->file('img') !== null) {
                $file = $request->file('img');
                $destinationPath = 'assets/img/posts';
                $file->move($destinationPath, $file->getClientOriginalName());
                $img = '/'.$destinationPath.'/'.$file->getClientOriginalName();
                $post->update([
                    'img' => $img
                ]);
            }

            // Create slug from title
            $request['slug'] = Str::slug($request['title'], '-');

            // Update Post with validated data
            $post->update($request);

            $this->tagsService->updateTags($post->id, $request->input('tags'));

            // Redirect the user to the created post woth an updated notification
            return $this->return(['success' => 'Post updated successfully'], Response::HTTP_ACCEPTED);
        }

        return $this->return([
            'error' => 'You can not edit this post'
        ], Response::HTTP_NOT_ACCEPTABLE);
    }

    public function destroy($post): JsonResponse
    {
        $post = Post::where('slug', $post)->first();
        if ($post->user_id == Auth::id()) {
            // Delete the specified Post
            $post->delete();
            $this->ratingsService->removeAll($post->id);
            $this->tagsService->removeAll($post->id);

            Bookmark::where('post', $post->id)->delete();

            return $this->return();
        } else {
            return $this->return(['error' => 'You can not remove this post'], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
