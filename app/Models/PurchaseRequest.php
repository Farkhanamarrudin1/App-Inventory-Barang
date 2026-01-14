<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $table = 'purchase_requests';

    /**
     * Kolom yang boleh diisi secara mass assignment
     */
    protected $fillable = [
        'pr_number',
        'pr_date',
        'created_by',
        'requester',
        'status',
        'approved_by',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'pr_date' => 'date',
    ];

    /**
     * Relasi ke item PR
     */
    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'purchase_request_id');
    }

    /**
     * User pembuat PR
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User approver PR
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
