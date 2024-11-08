<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'cover',
        'category_id',
        'brand_id',
    ];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'brand_id', 'id');
    }
}
