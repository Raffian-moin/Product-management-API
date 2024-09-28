<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ProductResource::collection(Product::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'bail|required|max:255',
                'price' => 'required|numeric|min:0.01',
                'stock' => 'required|integer|min:0',
            ]);

            $product = Product::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully.',
                'product' => new ProductResource($product),
            ], JsonResponse::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        return new ProductResource(Product::findOrFail($productId));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId)
    {
        try {
            $request->validate([
                'name' => 'bail|required|max:255',
                'price' => 'required|numeric|0.01',
                'stock' => 'required|integer|min:0',
            ]);

            // Find the product by ID
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $product->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully.',
                'product' => new ProductResource($product),
            ], JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    /**
     * Update partially the specified resource in storage.
     */
    public function updatePartial(Request $request, $productId)
    {
        try {
            if (count($request->all()) === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please provide at least one field',
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $request->validate([
                'name' => 'bail|sometimes|max:255',
                'price' => 'sometimes|numeric|0.01',
                'stock' => 'sometimes|integer|min:0',
            ]);

            // Find the product by ID
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $product->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully.',
                'product' => new ProductResource($product),
            ], JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
