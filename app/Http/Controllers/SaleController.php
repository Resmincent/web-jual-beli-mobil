<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the sales.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Sale::with('vehicle');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', '%' . $search . '%')
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        }

        $sales = $query->paginate(10);

        return view('admin.sales.index', compact('sales', 'search', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $vehicles = Vehicle::with('brands')->get();
        return view('admin.sales.create', compact('vehicles'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'buyer_name' => 'required|string|max:255',
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sale $sale)
    {
        $vehicles = Vehicle::with('brands')->get();
        return view('admin.sales.edit', compact('sale', 'vehicles'));
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'buyer_name' => 'required|string|max:255',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified sale from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.destroy')->with('success', 'Penjualan berhasil dihapus.');
    }
}
