<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Category;

class InvestorHomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::query()
            ->where('idea_type', 'traditional')
            ->where('approval_status', 'approved')
            ->with(['categories', 'entrepreneur']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('brief_description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%")
                  ->orWhereHas('entrepreneur', function ($q) use ($searchTerm) {
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

        $ideas = $query->latest()->paginate(10)->withQueryString();

        // Get all parent categories with their children for the filter
        $categories = Category::with('children')->whereNull('parent_id')->get();

        // Get selected categories for maintaining state
        $selectedCategories = $request->has('categories') ? explode(',', $request->categories) : [];

        return view('investor.home', compact('ideas', 'categories', 'selectedCategories'));
    }
}
