<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Factories\BookmarkFactory;
use App\Http\Services\BookmarksService;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookmarkController extends BaseController
{
    protected BookmarkFactory $bookmarkFactory;
    protected BookmarksService $bookmarksService;

    public function __construct(BookmarkFactory $bookmarkFactory, BookmarksService $bookmarksService)
    {
        $this->bookmarkFactory = $bookmarkFactory;
        $this->bookmarksService = $bookmarksService;
    }

    public function bookmark(int $post): JsonResponse
    {
        if (!Post::find($post)) {
            return $this->return(['error' => 'This post does not exist!'], Response::HTTP_NOT_FOUND);
        }

        if ($this->bookmarksService->isBookmarked($post)) {
            Bookmark::where('user_id', Auth::id())->where('post', $post)->delete();

            return $this->return(responseCode: Response::HTTP_NO_CONTENT);
        }

        $bookmark = $this->bookmarkFactory->create([
            'post' => $post,
            'user_id' => Auth::id()
        ], Bookmark::class);

        $bookmark->save();

        return $this->return(compact('bookmark'), Response::HTTP_CREATED);
    }
}
