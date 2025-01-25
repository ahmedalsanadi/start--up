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

        // Category filtering
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category)
                  ->orWhere('categories.parent_id', $request->category);
            });
        }

        $ideas = $query->latest()->paginate(10)->withQueryString();

        // Get all parent categories with their children for the filter
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('investor.home', compact('ideas', 'categories'));
    }
}
