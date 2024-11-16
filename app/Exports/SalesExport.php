<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
     * Mengambil data penjualan
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sale::all();
    }

    /**
     * Menambahkan headings pada file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pembeli',
            'Kendaraan',
            'Harga Penjualan',
            'Tanggal Penjualan',
        ];
    }
}
