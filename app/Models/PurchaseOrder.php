<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'po_number',
        'po_date',
        'purchase_request_id',
        'supplier_name',
        'supplier_address',
        'status'
    ];

    protected $casts = [
        'po_date' => 'date',
    ];

    public function pr()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function receipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function purchaseRequest()
    {
    return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

}
