<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page with filters for category and model.
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('model', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        $vehicles = $query->latest()->take(10)->get();

        $cars = Vehicle::where('category_id', 1)
            ->latest()
            ->take(10)
            ->get();


        $motorcycles = Vehicle::where('category_id', 2)
            ->latest()
            ->take(10)
            ->get();

        $categories = Category::all();
        $brands = Brand::all();

        return view('landing_page', compact('vehicles', 'cars', 'motorcycles', 'categories', 'brands'));
    }


    public function order($id)
    {
        $vehicle = Vehicle::with('brands', 'categories')->findOrFail($id);

        $whatsappNumber = preg_replace('/[^0-9]/', '', '6287888129093');

        $message = "Halo, saya tertarik dengan kendaraan berikut:\n\n" .
            "Nama: {$vehicle->name}\n" .
            "Model: {$vehicle->model}\n" .
            "Tahun: {$vehicle->year}\n" .
            "Harga: " . FormatRupiah($vehicle->price) . "\n\n" .
            "Silakan informasikan detail lebih lanjut.";

        $whatsappUrl = "https://api.whatsapp.com/send?phone=" . $whatsappNumber . "&text=" . urlencode($message);

        return view('detail_kendaraan', compact('vehicle', 'whatsappUrl'));
    }
}
