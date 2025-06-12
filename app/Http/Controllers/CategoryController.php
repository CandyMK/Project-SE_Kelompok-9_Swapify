<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::withCount('services')->get();
    //     return view('categories.index', compact('categories'));
    // }

    public function index()
    {
        // Menghitung layanan yang available untuk di-request
        $categories = Category::withCount(['services' => function ($query) {
            $query->whereNull('requested_by') 
                  ->where('status', 'available') 
                  ->where('is_active', true); 
        }])->get();

        return view('categories.index', compact('categories'));
    }

    public function showServices(Category $category)
    {
        $services = $category->services()
            ->with(['provider', 'category', 'reviews'])
            ->where('status', 'available')
            ->where('is_active', true)
            ->paginate(12);

        return view('categories.services', compact('category', 'services'));
    }

    public function showFilter(Category $category, Request $request)
    {
        $query = $category->services()->with(['user.reviews'])->where('is_active', true);

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $services = $query->latest()->paginate(9)->withQueryString(); // biar pagination tetap bawa query search

        return view('categories.services', compact('category', 'services'));
    }
}
