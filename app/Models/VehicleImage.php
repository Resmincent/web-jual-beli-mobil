<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    protected $fillable = ['vehicle_id', 'image'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
