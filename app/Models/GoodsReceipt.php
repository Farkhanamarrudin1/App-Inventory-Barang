<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'gr_number',
        'gr_date',
        'purchase_order_id',
        'received_by',
        'notes'
    ];

    /**
     * Relasi ke Purchase Order
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    /**
     * Relasi ke item-item GR
     */
    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'goods_receipt_id');
    }

    /**
     * Relasi ke user yang menerima barang
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
