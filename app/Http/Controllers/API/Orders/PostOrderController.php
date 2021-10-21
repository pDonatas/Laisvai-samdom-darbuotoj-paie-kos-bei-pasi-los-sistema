<?php declare(strict_types=1);

namespace App\Http\Controllers\API\Orders;

use App\Bookmark;
use App\Category;
use App\Exceptions\InvalidAPIResponseException;
use App\Factories\OrderFactory;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\PostRequest;
use App\Http\Services\RatingsService;
use App\Http\Services\TagsService;
use App\Order;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostOrderController extends BaseController
{
    protected OrderFactory $factory;

    public function __construct(OrderFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index(string $slug): JsonResponse
    {

        return $this->return(['orders' => Order::with('service')->get()]);
    }

    public function store(OrderRequest $request,string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            return $this->return(['error' => 'This post does not exist!'], Response::HTTP_BAD_REQUEST);
        }
        $order = $this->factory->create([
            'user_id' => Auth::id(),
            'requirement' => $request->input('requirements')
        ], Order::class);

        $order->save();

        $order->service()->attach($post);

        return $this->return(compact('order'), responseCode: Response::HTTP_CREATED);
    }

    /*public function show(Order $order, string $slug): JsonResponse
    {
        $posts = $order->service();
       /// $post = Post::where(['slug' => $slug])->first();
        return $this->return(compact('posts'));
    }*/

    public function update(string $slug,OrderRequest $request, $id): JsonResponse
    {
        $order = Order::with('service')->find($id);
        $order->factory->update($request->toArray());
        $order->save();

        return $this->return(compact('order'), responseCode: Response::HTTP_OK);
    }

    public function destroy(string $slug, $id): JsonResponse
    {
        $post = Post::where('slug', $slug)->first();
        $order = Order::with('service')->find($id);
        //$order->delete();
        $order->service()->detach($post->id);
        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }

    public function view(string $slug, $id): JsonResponse
    {
        $order = Order::with('service')->find($id);
        return $this->return(compact('order'));
    }
}
