<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product');

        if ($status = $request->input('status')) {
            $query->where('is_approved', $status === 'approved');
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Review approved.');
    }

    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        return back()->with('success', 'Review rejected.');
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        return back()->with('success', 'Review featured status updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
