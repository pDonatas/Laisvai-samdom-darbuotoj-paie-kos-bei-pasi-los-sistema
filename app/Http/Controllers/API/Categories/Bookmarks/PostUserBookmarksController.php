<?php declare(strict_types=1);

namespace App\Http\Controllers\API\Categories\Bookmarks;

use App\Bookmark;
use App\Category;
use App\Exceptions\InvalidAPIResponseException;
use App\Factories\RatingFactory;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\PostRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Services\RatingsService;
use App\Http\Services\TagsService;
use App\Post;
use App\Rating;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Request;
use Symfony\Component\HttpFoundation\Response;

class PostUserBookmarksController extends BaseController
{



    public function index(User $user, Post $post)
    {

        return $this->return(['bookmarks' => Bookmark::where('post', $post->id)->get()]);
    }

    public function store(User $user, $post): JsonResponse
    {
        $post = Post::where('slug', $post)->first();
        $bookmark = Bookmark::create([
            'post' => $post->id,
            'user_id' => $user->id
        ]);

        return $this->return(compact('bookmark'), Response::HTTP_CREATED);
    }

    public function show(User $user, $post, $bookmark): JsonResponse
    {
        $post = Post::where('slug', $post)->first();
        $bookmark = Bookmark::where('id',$bookmark)->where('user_id',$user->id)->where('post', $post->id)->first();

        if($bookmark == null)
            return $this->return(responseCode: Response::HTTP_NOT_FOUND);
        ///$bookmark = Bookmark::findOrFail($bookmark);
        return $this->return(compact('bookmark'));
    }

    public function update(User $user, Post $post, $bookmark, \Symfony\Component\HttpFoundation\Request $request): JsonResponse
    {
        $bookmark = Bookmark::findOrFail($bookmark);

        if ($bookmark->user_id != Auth::id()) {
            return $this->return([
                'error' => 'You can not edit this bookmark'
            ], Response::HTTP_FORBIDDEN);
        }

        $bookmark->update($request->toArray());

        return $this->return(compact('bookmark'), Response::HTTP_OK);
    }

    public function destroy(User $user, Post $post, $bookmark): JsonResponse
    {
        $bookmark = Bookmark::findOrFail($bookmark);

        if ($bookmark->user_id != Auth::id()) {
            return $this->return([
                'error' => 'You can not delete this bookmark'
            ], Response::HTTP_FORBIDDEN);
        }

        // Delete the specified Post
        $bookmark->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }
}
