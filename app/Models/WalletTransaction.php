<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $guarded = ['id'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
