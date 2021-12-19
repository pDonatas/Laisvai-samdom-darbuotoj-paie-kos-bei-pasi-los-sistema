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



    public function index($user, Post $post)
    {
        $user = User::where('id', $user)->first();
        $bookmarks = Bookmark::where(['post'=> $post->id, 'user_id' => $user->id])->get();
       // return $this->return(['bookmarks' => Bookmark::where('post', $post->id)->get()]);
        return $this->return($bookmarks->toArray());
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
        //$bookmark = Bookmark::findOrFail($bookmark);
        return $this->return($bookmark->toArray());
    }

    public function update($user, $post, $bookmark, \Symfony\Component\HttpFoundation\Request $request): JsonResponse
    {
        //$bookmark = Bookmark::findOrFail($bookmark);
        $post = Post::where('slug', $post)->first();
        $user = User::where('id', $user)->first();
        $bookmark = Bookmark::where('user_id',$user->id)->where('post', $post->id)->findOrFail($bookmark);
        if ($bookmark->user_id != Auth::id()) {
            return $this->return([
                'error' => 'You can not edit this bookmark'
            ], Response::HTTP_FORBIDDEN);
        }
        $array = $request->toArray();
        $post_id = $array['post'];
        $bookmark->update(['post' => $post_id]);
        $bookmark->save();

        return $this->return(compact('bookmark'), Response::HTTP_OK);
    }

    public function destroy($user, $post, $bookmark): JsonResponse
    {
        //$bookmark = Bookmark::findOrFail($bookmark);
        $post = Post::where('slug', $post)->first();
        $user = User::where('id', $user)->first();
        $bookmark = Bookmark::where('user_id',$user->id)->where('post', $post->id)->findOrFail($bookmark);
        if ($bookmark->user_id != Auth::id()) {
            return $this->return([
                'error' => 'You can not delete this bookmark'
            ], Response::HTTP_FORBIDDEN);
        }

        // Delete the specified Bookmark
        $bookmark->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }
}
