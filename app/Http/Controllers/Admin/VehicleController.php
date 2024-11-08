<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Carbon\Carbon;
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

        // Search by name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Filter by date range
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
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
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicle_images', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = json_encode($imagePaths);
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Vehicle::where('id', $id)->findOrFail($id);
        return view('admin.vehicle.detail', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicle.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('thumbnail')) {
            if ($vehicle->thumbnail) {
                Storage::disk('public')->delete($vehicle->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('images')) {
            if ($vehicle->images) {
                foreach (json_decode($vehicle->images) as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicle_images', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = json_encode($imagePaths);
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->thumbnail) {
            Storage::disk('public')->delete($vehicle->thumbnail);
        }

        if ($vehicle->images) {
            foreach (json_decode($vehicle->images) as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
