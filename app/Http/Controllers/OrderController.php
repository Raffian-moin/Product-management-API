<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->verifyUser();

        if ($response instanceof JsonResponse) {
            return $response;
        } else {
            $userId = $response;
        }

        $grandTotal = Order::sum('total_amount');

        // get the orders of authenticated user
        $orders = Order::with(['orderItems.product', 'user'])
            ->where('user_id', $userId)
            ->paginate(10);

        return OrderResource::collection($orders)
            ->additional(['total_order_amount' => $grandTotal]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $response = $this->verifyUser();

        if ($response instanceof JsonResponse) {
            return $response;
        } else {
            $userId = $response;
        }

        DB::beginTransaction();
        try {
            $allProducts = Product::pluck('stock', 'id')->toArray();

            $orderItems = $request->all();


            $response = $this->verifyRequest($allProducts, $orderItems);

            if ($response instanceof JsonResponse) {
                return $response;
            }

            // Create the order
            $order = Order::create([
                'user_id' => $userId, // Assuming user is authenticated
                'total_amount' => 0, // We will update this later
            ]);

            $totalPrice = 0; // To store the total order price

            // Iterate over the order items and handle each one
            foreach ($orderItems as $item) {
                // Find the product
                $product = Product::findOrFail($item['product_id']);
                // Reduce the stock
                $product->stock -= $item['quantity'];
                $product->save();

                // Calculate the total price for the order
                $itemPrice = $product->price * $item['quantity'];
                $totalPrice += $itemPrice;

                // Store the order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sub_total' => $itemPrice,
                ]);
            }

            // Update the total price of the order
            $order->total_amount = $totalPrice;
            $order->save();

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order Placed successfully.',
                'order' => new OrderResource($order),
            ], JsonResponse::HTTP_CREATED);


        } catch (ValidationException $e) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($orderId)
    {
        return new OrderResource(Order::with(['orderItems.product', 'user'])->where('id', $orderId)->first());
    }

    public function verifyRequest($allProducts, $orderItems) {
        foreach ($orderItems as $key => $item) {
            if (!array_key_exists('product_id', $item) || !array_key_exists('quantity', $item)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Incorrect Request Format',
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            } else if ($item['quantity'] === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product quantity must be greater than 0',
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            } else if (! array_key_exists($item['product_id'], $allProducts)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Product id: {$item['product_id']}  not found",
                ], JsonResponse::HTTP_NOT_FOUND);
            } else if ($item['quantity'] > $allProducts[$item['product_id']]) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Product id: {$item['product_id']}  available stock is {$allProducts[$item['product_id']]}, but you ordered {$order['quantity']}",
                ], JsonResponse::HTTP_NOT_FOUND);
            }
        }
    }

    public function verifyUser()
    {
        if (Auth::guard()->user()) {
            return Auth::guard()->user()->id;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Please Provide valid JWT token to place the order',
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
