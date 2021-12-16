<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Factories\OrderFactory;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    protected OrderFactory $factory;

    public function __construct(OrderFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index(): JsonResponse
    {
        $orders = Auth::user()->orders()->with('service')->get();
        if ($orders == null) {
            $this->return(responseCode: Response::HTTP_NOT_FOUND);
        }
        return $this->return(compact('orders'));
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $post = Post::where('slug', $request->input('slug'))->first();
        if (!$post) {
            return $this->return(['error' => 'This post does not exist!'], Response::HTTP_BAD_REQUEST);
        }
        $order = $this->factory->create([
            'user_id' => Auth::id(),
            'requirement' => $request->input('requirements')
        ], Order::class);

        $order->save();

        // @phpstan-ignore-next-line
        $order->service()->attach($post);

        return $this->return(compact('order'), responseCode: Response::HTTP_CREATED);
    }

    public function show(Order $order): JsonResponse
    {
        return $this->return(compact('order'));
    }

    public function update(OrderRequest $request, $id): JsonResponse
    {
      /*  $order = Order::find($id);
        $order->update($request->toArray());*/
        $order = Order::where('id', $id)->first();
        $array = $request->toArray();
        $requirement = $array['requirements'];
        $order->update(['requirement' => $requirement]);
        $order->save();
        //$order = Order::find($id);;
        return $this->return(compact('order'),Response::HTTP_OK);
    }

    public function destroy($id): JsonResponse
    {
        $order = Order::with('service')->find($id);
        $order->service()->detach();
        $order->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }

    public function view($id): JsonResponse
    {
        $order = Order::with('service')->findOrFail($id);

        return $this->return(compact('order'));
    }
}

