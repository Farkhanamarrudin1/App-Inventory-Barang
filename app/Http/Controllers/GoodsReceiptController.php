<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Barang;
use Illuminate\Http\Request;

class GoodsReceiptController extends Controller
{
    public function index()
    {
        $data = GoodsReceipt::with('items')->latest()->paginate(10);
        return view('purchasing.gr.index', compact('data'));
    }

    public function create($poId = null)
    {
        $po = PurchaseOrder::with('items.barang')->findOrFail($poId);
        return view('purchasing.gr.create', compact('po'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gr_date' => 'required|date',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.received_qty' => 'required|integer|min:1',
        ]);

        // Generate GR number
        $last = GoodsReceipt::latest()->first();
        $nextNumber = 'GR-' . str_pad(($last?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        // Create GR
        $gr = GoodsReceipt::create([
            'gr_number' => $nextNumber,
            'gr_date' => $request->gr_date,
            'purchase_order_id' => $request->purchase_order_id,
            'received_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        // Insert GR items + update stock
        foreach ($request->items as $item) {

            GoodsReceiptItem::create([
                'goods_receipt_id' => $gr->id,
                'barang_id' => $item['barang_id'],
                'received_qty' => $item['received_qty'],
                'condition' => $item['condition'] ?? 'baik',
            ]);

            $barang = Barang::find($item['barang_id']);
            $barang->jumlah += $item['received_qty'];
            $barang->save();
        }

        // === LOGIC STATUS OTOMATIS PO ===

        $po = PurchaseOrder::with('items')->find($request->purchase_order_id);

        // Total qty pada PO
        $totalPO = PurchaseOrderItem::where('purchase_order_id', $po->id)->sum('qty');

        // Total barang yang sudah diterima dari GR
        $totalReceived = GoodsReceiptItem::whereHas('goodsReceipt', function ($q) use ($po) {
            $q->where('purchase_order_id', $po->id);
        })->sum('received_qty');

        // Tentukan status otomatis
        if ($totalReceived == 0) {
            $po->status = 'Open';
        } 
        elseif ($totalReceived > 0 && $totalReceived < $totalPO) {
            $po->status = 'Partially Received';
        } 
        elseif ($totalReceived >= $totalPO) {
            $po->status = 'Received';
        }

        $po->save();

        return redirect()->route('gr.index')
            ->with('success', 'Goods Receipt berhasil dibuat dan status PO diperbarui otomatis!');
    }

    public function show($id)
    {
        $gr = GoodsReceipt::with('items.barang', 'purchaseOrder')->findOrFail($id);
        return view('purchasing.gr.show', compact('gr'));
    }

    public function destroy($id)
    {
        $gr = GoodsReceipt::findOrFail($id);

        GoodsReceiptItem::where('goods_receipt_id', $gr->id)->delete();
        $gr->delete();

        return back()->with('success', 'Goods Receipt berhasil dihapus!');
    }
}
