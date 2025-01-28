<?php

namespace App\Http\Controllers\Entrepreneur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;

class EntrepreneurHomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query()
            ->where('approval_status', 'approved') // Only show approved announcements
            ->where('is_closed', false) // Only show open announcements
            ->with(['categories', 'investor']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%")
                  ->orWhereHas('investor', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Multiple subcategories filtering - must match ALL selected categories
        if ($request->has('categories')) {
            $categoryIds = array_filter(explode(',', $request->categories));
            if (!empty($categoryIds)) {
                foreach ($categoryIds as $categoryId) {
                    $query->whereHas('categories', function ($q) use ($categoryId) {
                        $q->where('categories.id', $categoryId);
                    });
                }
            }
        }

        $announcements = $query->latest()->paginate(10)->withQueryString();

        // Get all parent categories with their children for the filter
        $categories = Category::with('children')->whereNull('parent_id')->get();

        // Get selected categories for maintaining state
        $selectedCategories = $request->has('categories') ? explode(',', $request->categories) : [];

        return view('entrepreneur.home', compact('announcements', 'categories', 'selectedCategories'));
    }
}
