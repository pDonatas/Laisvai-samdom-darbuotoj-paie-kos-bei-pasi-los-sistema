<?php declare(strict_types=1);

namespace App\Http\Controllers\API\Categories\Votes;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostCategoryVotesController extends BaseController
{
    protected TagsService $tagsService;
    protected RatingsService $ratingsService;
    protected RatingFactory$ratingFactory;

    public function __construct(TagsService $tagsService, RatingsService $ratingsService, RatingFactory $ratingFactory)
    {
        $this->tagsService = $tagsService;
        $this->ratingsService = $ratingsService;
        $this->ratingFactory = $ratingFactory;
    }

    public function index(Category $category, Post $post)
    {
        return $this->return(['votes' => Rating::with('user')->where('post', $post->id)->get()]);
    }

    public function store(Category $category, RatingRequest $request, Post $post): JsonResponse
    {
        $data = $request->toArray();
        if ($this->ratingsService->voted(Auth::id(), $post->id)) {
            return $this->return(['errors' => 'You already voted for this post'], responseCode: Response::HTTP_BAD_REQUEST);
        }
        $data['user'] = Auth::id();
        $data['post'] = $post->id;
        $rating = $this->ratingFactory->create($data, Rating::class);
        $rating->save();

        return $this->return(compact('rating'), responseCode: Response::HTTP_CREATED);
    }

    public function show(Category $category, Post $post, Rating $rating): JsonResponse
    {
        return $this->return(compact('rating'));
    }

    public function update(Category $category, RatingRequest $request, Post $post, Rating $rating): JsonResponse
    {
        if (!$rating->user == Auth::id()) {
            return $this->return([
                'error' => 'You can not edit this vote'
            ], Response::HTTP_FORBIDDEN);
        }

        $rating->update($request->toArray());

        return $this->return(compact('rating'), responseCode: Response::HTTP_ACCEPTED);
    }

    public function destroy(Category $category, Post $post, Rating $rating): JsonResponse
    {
        if (!$rating->user == Auth::id()) {
            return $this->return([
                'error' => 'You can not delete this vote'
            ], Response::HTTP_FORBIDDEN);
        }

        // Delete the specified Post
        $rating->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }
}
