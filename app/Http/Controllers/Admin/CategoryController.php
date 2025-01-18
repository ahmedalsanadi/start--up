<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Get main categories (those without parents) with their children
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->latest()
            ->paginate(6); // Paginate with 6 categories per page

        return view('admin.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        // تحميل الفئة الأب (إذا كانت موجودة)
        $parentCategory = $category->parent;

        // تحميل الفئات الفرعية
        $children = $category->children()->latest()->paginate(10);

        return view('admin.categories.show', compact('category', 'parentCategory', 'children'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(Request $request)
    {
        // Get only parent categories for the dropdown
        $parentCategories = Category::whereNull('parent_id')->get();

        // Get the parent_id from the query parameters (if it exists)
        $parent_id = $request->query('parent_id');

        return view('admin.categories.create', compact('parentCategories', 'parent_id'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Ensure the name is unique across all categories, regardless of parent_id
                Rule::unique('categories'),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Check if the selected parent has a parent (prevent multi-level nesting)
                        $parent = Category::find($value);
                        if ($parent && $parent->parent_id !== null) {
                            $fail('لا يمكن إنشاء قسم فرعي تحت قسم فرعي آخر.');
                        }
                    }
                },
            ],
        ]);

        // Create the category
        Category::create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?: null,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'تم إنشاء القسم بنجاح.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        // Get potential parent categories, excluding the current category and its children
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->whereNotIn('id', $category->children->pluck('id'))
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Ensure the name is unique within the same parent_id scope, excluding the current category
                Rule::unique('categories')->ignore($category->id),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value) {
                        // Prevent category from being its own parent
                        if ($value == $category->id) {
                            $fail('لا يمكن أن يكون القسم والداً لنفسه.');
                            return;
                        }

                        // Check if the selected parent has a parent (prevent multi-level nesting)
                        $parent = Category::find($value);
                        if ($parent && $parent->parent_id !== null) {
                            $fail('لا يمكن إنشاء قسم فرعي تحت قسم فرعي آخر.');
                            return;
                        }

                        // Prevent circular references
                        if ($category->children->contains($value)) {
                            $fail('لا يمكن تعيين قسم فرعي كقسم رئيسي.');
                            return;
                        }
                    }
                },
            ],
        ]);

        // Update the category
        $category->update([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?: null,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'تم تحديث القسم بنجاح.');
    }

    /**
     * Delete the specified category.
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();
        return redirect()
            ->route('categories.index')
            ->with('success', 'تم حذف القسم بنجاح.');
    }
}
