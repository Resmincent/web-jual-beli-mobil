<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_id',
        'sale_price',
        'sale_date',
        'buyer_name',
    ];

    /**
     * Get the vehicle associated with the sale.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
