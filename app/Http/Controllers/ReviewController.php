<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\CartRecord;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'orderID' => 'required|exists:orders,orderID',
            'productID' => 'required|exists:products,productID',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'showName' => 'boolean',
        ]);
    
        // Check if the order belongs to the authenticated user
        $order = Order::where('orderID', $validated['orderID'])
            ->where('userID', Auth::id())
            ->first();
    
        if (!$order) {
            return back()->with('error', 'You can only review products from your own orders');
        }
    
        // Check if the product exists in the order
        $productExists = $order->cartRecords()
            ->whereHas('productSizing.productVariant', function($query) use ($validated) {
                $query->where('productID', $validated['productID']);
            })
            ->exists();
    
        if (!$productExists) {
            return back()->with('error', 'This product is not in the specified order');
        }
    
        // Check if a review already exists for this order and product
        $existingReview = Review::where('orderID', $validated['orderID'])
            ->whereHas('order.cartRecords.productSizing.productVariant', function($query) use ($validated) {
                $query->where('productID', $validated['productID']);
            })
            ->first();
    
        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? '',
                'showName' => $request->has('showName') ? true : false,
            ]);
    
            $message = 'Review updated successfully';
        } else {
            // Create new review
            Review::create([
                'orderID' => $validated['orderID'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? '',
                'showName' => $request->has('showName') ? true : false,
            ]);
    
            $message = 'Review submitted successfully';
        }
    
        // Redirect to the product view page with a success message
        return redirect()->route('products.view', $validated['productID'])
            ->with('success', $message);
    }

    /**
     * Admin: List all reviews
     */
    public function index()
    {
        // Ensure this is only accessible by admins (middleware should handle this)
        $reviews = Review::with(['order.user', 'order.cartRecords.productSizing.productVariant.product'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Admin: Edit review form
     */
    public function edit(Review $review)
    {
        // Ensure this is only accessible by admins (middleware should handle this)
        $review->load(['order.user', 'order.cartRecords.productSizing.productVariant.product']);
        
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Admin: Update review
     */
    public function update(Request $request, Review $review)
    {
        // Ensure this is only accessible by admins (middleware should handle this)
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully');
    }

    /**
     * Admin: Delete review
     */
    public function destroy(Review $review)
    {
        // Ensure this is only accessible by admins (middleware should handle this)
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
    }

    /**
     * Display reviews by cartID
     */
    public function showByCartID($cartID)
    {
        $reviews = Review::getReviewsByCartID($cartID);
        
        // Calculate review statistics
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Rating breakdown
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $ratingBreakdown[$i] = [
                'count' => $count,
                'percentage' => $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0
            ];
        }
        
        return view('customer.reviews.by_cart', compact('reviews', 'totalReviews', 'averageRating', 'ratingBreakdown', 'cartID'));
    }

    /**
     * Display reviews by cartRecordID
     */
    public function showByCartRecordID($cartRecordID)
    {
        $cartRecord = CartRecord::with('productSizing.productVariant.product')
            ->findOrFail($cartRecordID);
        
        $reviews = Review::getReviewsByCartRecordID($cartRecordID);
        
        // Calculate review statistics
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Rating breakdown
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $ratingBreakdown[$i] = [
                'count' => $count,
                'percentage' => $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0
            ];
        }
        
        return view('customer.reviews.by_cart_record', compact(
            'reviews', 
            'totalReviews', 
            'averageRating', 
            'ratingBreakdown', 
            'cartRecord'
        ));
    }
}