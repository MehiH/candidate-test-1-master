<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTag;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index')->withorders(Order::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create')->withOrder(new Order)->withCustomers(Customer::get())->withTags(Tag::get())->withSelectedtag([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'cost' => 'required',
            'tags' => 'required',
        ]);
        
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->title = $request->title;
        $order->description = $request->description;
        $order->cost = $request->cost;
        $order->save();

        $cnt = new Contract();
        $cnt->order_id =  $order->id;
        $cnt->customer_id = $request->customer_id;
        $cnt->save();

        foreach($request->tags as $tag){
            $oTag = new OrderTag();
            $oTag->order_id =  $order->id;
            $oTag->tag_id = $tag;
            $oTag->save();
        }

        return redirect()->route('orders.edit', $order)->withMessage('Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $tags = DB::table('tags')
                ->select('tags.id')
                ->join('order_tags', 'tags.id', '=', 'order_tags.tag_id')
                ->where('order_tags.order_id',$order->id)
                ->get();
        $tag = [];
        foreach($tags as $t){
           
            $tag[] = $t->id; 
        }
        //print_r($tag);exit;
        return view('orders.edit', compact('order'))->withCustomers(Customer::get())->withTags(Tag::get())->withSelectedtag($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'cost' => 'required',
            'tags' => 'required',
        ]);
        
        $order = Order::find($id);
        $order->customer_id = $request->customer_id;
        $order->title = $request->title;
        $order->description = $request->description;
        $order->cost = $request->cost;
        $order->save();
        OrderTag::where('order_id',$id)->delete();

        foreach($request->tags as $tag){
            $oTag = new OrderTag();
            $oTag->order_id =  $order->id;
            $oTag->tag_id = $tag;
            $oTag->save();
        }

        return redirect()->route('orders.edit', $order)->withMessage('Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
        Contract::where('order_id',$order)->delete();
        Order::find($order)->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
