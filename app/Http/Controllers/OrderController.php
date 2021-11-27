<?php

namespace App\Http\Controllers;

use App\Order;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware('verify');
    }

    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        $user = Auth::id();

        $services =
            DB::table('orders')
            ->join('posts', 'orders.service', '=', 'posts.id')
            ->select('orders.id', 'posts.title')->where('posts.user_id', '=', $user)
            ->get();

        $orders = DB::table('orders')
            ->join('posts', 'orders.service', '=', 'posts.id')
            ->select('orders.id', 'posts.title')
            ->where('orders.user_id', '=', $user)
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function create($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('orders.create', compact('post'));
    }

    /**
     * @codeCoverageIgnore
     */
    public function view($id)
    {
        $order = Order::findOrFail($id);
        $post = Post::findOrFail($order->service);
        return view('orders.create', [
            'order' => $order,
            'post' => $post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function store(Request $request, $data)
    {
        $post = Post::where('slug', $data)->first();
        $order = new Order();
        $order->user_id = Auth::id();
        $order->requirement = $request->input('requirements');
        $order->save();

        return redirect(route('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function destroy(Order $order)
    {
        //
    }
}
