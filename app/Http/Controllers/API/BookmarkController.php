<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Factories\BookmarkFactory;
use App\Http\Services\BookmarksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        if ($this->bookmarksService->isBookmarked($post)) {
            Bookmark::where('user_id', Auth::id())->where('post', $post)->delete();
        } else {
            $bookmark = $this->bookmarkFactory->create([
                'post' => $post,
                'user_id' => Auth::id()
            ], Bookmark::class);

            $bookmark->save();
        }

        return $this->return();
    }
}
