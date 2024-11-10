<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validatedData['image'] = $imagePath;
        }

        Vehicle::create($validatedData);
        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil di tambahkan');
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
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }

            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validatedData['image'] = $imagePath;
        }

        $vehicle->update($validatedData);

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            DB::beginTransaction();

            // Delete image if exists
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }

            // Delete the vehicle
            $vehicle->delete();

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('vehicles.index')->with('error', 'Gagal menghapus kendaraan');
        }
    }
}
