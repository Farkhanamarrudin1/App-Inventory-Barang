<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_request_items';

    protected $fillable = [
        'purchase_request_id',
        'barang_id',
        'qty',
        'unit'
    ];

    public function pr()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
