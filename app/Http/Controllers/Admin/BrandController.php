<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;



class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $brands = $query->paginate(10);

        // Ambil semua kategori dari tabel categories
        $categories = Category::all();

        return view('admin.brand.index', compact('brands', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->only(['name', 'category_id']);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('brands_covers', 'public');
            $data['cover'] = $coverPath;
        }

        $data['slug'] = Str::slug($data['name']);
        Brand::create($data);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',

        ]);

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('brands_covers', 'public');
            if ($brand->cover) {
                Storage::disk('public')->delete($brand->cover);
            }
            $data['cover'] = $coverPath;
        }

        $data['slug'] = Str::slug($data['name']);

        $brand->update($data);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->cover) {
            Storage::disk('public')->delete($brand->cover);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
