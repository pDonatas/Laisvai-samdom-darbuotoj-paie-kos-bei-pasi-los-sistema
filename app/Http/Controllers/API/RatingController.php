<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Factories\RatingFactory;
use App\Http\Requests\RatingRequest;
use App\Http\Services\RatingsService;
use App\Post;
use App\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends BaseController
{
    protected RatingsService $ratingsService;
    protected RatingFactory $ratingFactory;

    public function __construct(RatingsService $ratingsService, RatingFactory $ratingFactory)
    {
        $this->ratingsService = $ratingsService;
        $this->ratingFactory = $ratingFactory;
    }

    public function vote(RatingRequest $request, $post): JsonResponse
    {
        $post = Post::find($post);
        if (!$post) {
            return $this->return(['error' => 'This post does not exist!'], Response::HTTP_NOT_FOUND);
        }
        if ($this->ratingsService->exists($post)) {
            if (!$this->ratingsService->voted(Auth::id(), $post)) {
                $rating = $this->ratingFactory->create([
                    'vote' => $request->get('vote'),
                    'user' => Auth::id(),
                    'comment' => $request->get('comment'),
                    'post' => $post->id
                ], Rating::class);

                $rating->save();

                return $this->return(compact('rating'), responseCode: Response::HTTP_CREATED);
            }
        }

        return $this->return(responseCode: Response::HTTP_NOT_FOUND);
    }

    public function show($post): JsonResponse
    {
        if (!Session::has('sort')) {
            Session::put('sort', '1');
        }

        $sort = Session::get('sort');
        $rts = null;
        //Pagal balsus
        if ($sort == 0) {
            $rts = Rating::where('post', $post)->orderBy('vote')->get();
        } elseif ($sort == 1) { //Data
            $rts = Rating::where('post', $post)->orderBy('created_at')->get();
        }

        return $this->return(compact('rts'));
    }

    public function sort(Request $request): JsonResponse
    {
        $data = $request->input("sort");
        Session::forget("sort");
        Session::put("sort", $data);

        return $this->return();
    }

    public function remove(Rating $vote): JsonResponse
    {
        if (!$vote->user == Auth::id()) {
            return $this->return([
                'error' => 'You can not remove this vote'
            ], Response::HTTP_FORBIDDEN);
        }

        $vote->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }
}
