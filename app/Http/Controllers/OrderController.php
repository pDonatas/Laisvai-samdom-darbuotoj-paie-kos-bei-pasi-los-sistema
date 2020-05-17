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
    public function __construct()
    {
        $this->middleware('verify');
    }


    public function index()
    {
        $user = Auth::id();

        $orders = DB::raw("SELECT `orders`.`id`, `posts`.`title` FROM `orders` INNER JOIN `posts` ON `orders`.`service`=`posts`.`id` WHERE `orders`.`user` = '$user'");

        $services = DB::raw(
          "SELECT `orders`.`id`, `posts`.`title` FROM `orders`
                INNER JOIN `posts` ON `orders`.`service`=`posts`.`id`
                WHERE `posts`.`user_id` = '$user'"
        );
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
    public function create($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('orders.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $data)
    {
        $post = Post::where('slug', $data)->first();
        $order = new Order();
        $order->user = Auth::id();
        $order->service = $post->id;
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
    public function destroy(Order $order)
    {
        //
    }
}
