<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\DeliveryRating;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function submitRatings(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_rating.delivery_user_id' => 'required|exists:delivery_user,id',
            'delivery_rating.rating' => 'required|integer',
            'product_ratings' => 'required|array|min:1',
            'product_ratings.*.product_id' => 'required|exists:product,id',
            'product_ratings.*.rating' => 'required|integer|min:1|max:5',
            'product_ratings.*.description' => 'nullable|string',
            'product_ratings.*.images' => 'nullable|array',
            'product_ratings.*.images.*' => 'file|image|max:2048',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        $deliveryRatingData = $validated['delivery_rating'];
        $deliveryImagePaths = [];
        DeliveryRating::create([
            'order_id' => $validated['order_id'],
            'delivery_user_id' => $deliveryRatingData['delivery_user_id'],
            'user_id' => $request->user_id,
            'rating' => $deliveryRatingData['rating'],
            'description' => $deliveryRatingData['description'] ?? null,
            'images' => json_encode($deliveryImagePaths),
        ]);

        foreach ($validated['product_ratings'] as $productRatingData) {
            $orderItem = Order_items::where('order_id', $validated['order_id'])
                ->where('product_id', $productRatingData['product_id'])
                ->first();

            if (!$orderItem) {
                continue;
            }

            $deliveryImagePaths = [];

            if ($request->hasFile('delivery_rating.images')) {
                foreach ($request->file('delivery_rating.images') as $image) {
                    $imageName = time() . '_delivery_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/delivery_ratings'), $imageName);
                    $full_path = "uploads/delivery_ratings/" . $imageName;
                    $deliveryImagePaths[] = $full_path;
                }
            }
            ProductRating::create([
                'order_id' => $validated['order_id'],
                'product_id' => $productRatingData['product_id'],
                'user_id' => $request->user_id,
                'rating' => $productRatingData['rating'],
                'description' => $productRatingData['description'] ?? null,
                'images' => json_encode($deliveryImagePaths),
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Ratings submitted successfully'], 201);
    }

    public function getRatings($order_id, $user_id)
    {
        $order = Order::where('id', $order_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $deliveryRating = DeliveryRating::join('delivery_user', 'delivery_rating.delivery_user_id', '=', 'delivery_user.id')
            ->select('delivery_rating.*', 'delivery_user.name as delivery_user_name')
            ->where('delivery_rating.order_id', $order_id)
            ->where('delivery_rating.user_id', $user_id)
            ->first();

        $productRatings = ProductRating::join('product', 'product_rating.product_id', '=', 'product.id')
            ->select('product_rating.*', 'product.product_name as product_name')
            ->where('product_rating.order_id', $order_id)
            ->where('product_rating.user_id', $user_id)
            ->get();

        return response()->json([
            'status' => true,
            'order_id' => $order_id,
            'delivery_rating' => $deliveryRating,
            'product_ratings' => $productRatings,
        ]);
    }

}
