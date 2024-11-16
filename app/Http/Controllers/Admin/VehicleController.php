<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
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
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Vehicle::with('brands', 'categories');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $vehicles = $query->paginate(10);

        return view('admin.vehicle.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.vehicle.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'year' => 'required|string|max:15',
            'model' => 'required|string|max:20',
            'transmition' => 'required|string|max:20',
            'mileage' => 'required|string|max:30',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_images' => 'required|array|min:1',
            'vehicle_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('vehicles/thumbnails', 'public');
                $validatedData['thumbnail'] = $thumbnailPath;
            }

            $vehicle = Vehicle::create($validatedData);

            if ($request->hasFile('vehicle_images')) {
                foreach ($request->file('vehicle_images') as $image) {
                    $imagePath = $image->store('vehicles/images', 'public');
                    $vehicle->images()->create(['image' => $imagePath]);
                }
            }

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vehicle = Vehicle::where('id', $id)->findOrFail($id);
        return view('admin.vehicle.detail', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.vehicle.edit', compact('vehicle', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'year' => 'required|string|max:15',
            'model' => 'required|string|max:20',
            'transmition' => 'required|string|max:20',
            'mileage' => 'required|string|max:30',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_images' => 'nullable|array',
            'vehicle_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:vehicle_images,id'
        ]);

        try {
            DB::beginTransaction();

            $vehicle = Vehicle::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                if ($vehicle->thumbnail && Storage::disk('public')->exists($vehicle->thumbnail)) {
                    Storage::disk('public')->delete($vehicle->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')->store('vehicles/thumbnails', 'public');
                $validatedData['thumbnail'] = $thumbnailPath;
            }

            $vehicle->update($validatedData);

            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = $vehicle->images()->find($imageId);
                    if ($image) {
                        if (Storage::disk('public')->exists($image->image)) {
                            Storage::disk('public')->delete($image->image);
                        }
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('vehicle_images')) {
                foreach ($request->file('vehicle_images') as $image) {
                    $imagePath = $image->store('vehicles/images', 'public');
                    $vehicle->images()->create(['image' => $imagePath]);
                }
            }

            DB::commit();
            return redirect()->route('vehicles.index')
                ->with('success', 'Kendaraan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $vehicle = Vehicle::findOrFail($id);

            if ($vehicle->thumbnail && Storage::disk('public')->exists($vehicle->thumbnail)) {
                Storage::disk('public')->delete($vehicle->thumbnail);
            }

            foreach ($vehicle->images as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
                $image->delete();
            }

            $vehicle->delete();

            DB::commit();
            return redirect()->route('vehicles.index')
                ->with('success', 'Kendaraan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
