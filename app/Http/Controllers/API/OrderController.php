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
        $orders = Auth::user()->orders()->get();

        return $this->return(compact('orders'));
    }

    public function store(Request $request, $data): JsonResponse
    {
        $post = Post::where('slug', $data)->first();

        $order = $this->factory->create([
            'user' => Auth::user(),
            'service' => $post,
            'requirement' => $request->input('requirements')
        ], Order::class);

        $order->save();

        return $this->return(responseCode: Response::HTTP_CREATED);
    }

    public function show(Order $order): JsonResponse
    {
        return $this->return(compact('order'));
    }

    public function update(OrderRequest $request, Order $order): JsonResponse
    {
        $order = $this->factory->update($order, $request->toArray());

        $order->save();

        return $this->return(responseCode: Response::HTTP_ACCEPTED);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return $this->return();
    }
}

