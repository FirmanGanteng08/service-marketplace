<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function packages()
    {
        return $this->hasMany(ServicePackage::class);
    }
}
