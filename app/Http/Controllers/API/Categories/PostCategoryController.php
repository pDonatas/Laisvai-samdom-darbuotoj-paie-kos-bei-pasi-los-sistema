<?php declare(strict_types=1);

namespace App\Http\Controllers\API\Categories;

use App\Bookmark;
use App\Category;
use App\Exceptions\InvalidAPIResponseException;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\PostRequest;
use App\Http\Services\RatingsService;
use App\Http\Services\TagsService;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostCategoryController extends BaseController
{
    protected TagsService $tagsService;
    protected RatingsService $ratingsService;

    public function __construct(TagsService $tagsService, RatingsService $ratingsService)
    {
        $this->tagsService = $tagsService;
        $this->ratingsService = $ratingsService;
    }

    public function index(Category $category)
    {
        return $this->return(['posts' => Post::where('category', $category->id)->get()]);
    }

    public function store(Category $category, PostRequest $request): JsonResponse
    {
        $data = $request->toArray();
        if ($request->file('img')) {
            $file = $request->file('img');
            $destinationPath = 'assets/img/posts';
            $file->move($destinationPath, $file->getClientOriginalName());
            $img = '/' . $destinationPath . '/' . $file->getClientOriginalName();
            $data['img'] = $img;
        }

        // Create slug from title
        $data['slug'] = Str::slug($data['title'], '-');
        $data['user_id'] = Auth::id();
        $data['category'] = $category->id;

        // Create and save post with validated data
        $post = Post::create($data);
        //Gaunam tagus ir juos issaugom
        if ($request->input('tags')) {
            $this->tagsService->saveTags($post->id, $request->input('tags'));
        }
        // Redirect the user to the created post with a success notification
        return $this->return(compact('post'), Response::HTTP_CREATED);
    }

    public function show(Category $category, string $slug): JsonResponse
    {
        $post = Post::where(['slug' => $slug, 'category' => $category->id])->first();

        if (!$post) {
            return $this->return(responseCode: Response::HTTP_NOT_FOUND);
        }

        $rate = RatingsService::overall($post->id);

        return $this->return(compact('post', 'rate'));
    }

    public function update(Category $category, PostRequest $request, $post): JsonResponse
    {
        $post = Post::where(['slug' => $post, 'category' => $category->id])->first();

        if (!$post) {
            return $this->return(responseCode: Response::HTTP_NOT_FOUND);
        }

        $data = $request->toArray();
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
            $data['slug'] = Str::slug($data['title'], '-');

            // Update Post with validated data
            $post->update($data);
            if ($request->input('tags')) {
                $this->tagsService->updateTags($post->id, $request->input('tags'));
            }

            // Redirect the user to the created post woth an updated notification
            return $this->return(compact('post'), Response::HTTP_ACCEPTED);
        }

        return $this->return([
            'error' => 'You can not edit this post'
        ], Response::HTTP_FORBIDDEN);
    }

    public function destroy(Category $category, $post): JsonResponse
    {
        $post = Post::where(['slug' => $post, 'category' => $category->id])->first();
        if (!$post) {
            return $this->return(responseCode: Response::HTTP_NOT_FOUND);
        }

        if ($post->user_id != Auth::id()) {
            return $this->return(["error" => "You can remove only your created posts"], responseCode: Response::HTTP_FORBIDDEN);
        }

        // Delete the specified Post
        $post->delete();
        $this->ratingsService->removeAll($post->id);
        $this->tagsService->removeAll($post->id);

        Bookmark::where('post', $post->id)->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }
}
