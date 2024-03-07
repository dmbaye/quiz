<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $categories = Category::paginate(15);

        return view('settings.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()
            ->with('success', 'La catégorie a été ajouter.');
    }

    public function show(Category $category)
    {
        return view('settings.categories.show', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories,name',
        ]);

        $category::update([
            'name' => $request->name,
        ]);

        return redirect()->back()
            ->with('success', 'La catégorie a été modifier.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
            ->with('success', 'La catégorie a été supprimer.');
    }
}
