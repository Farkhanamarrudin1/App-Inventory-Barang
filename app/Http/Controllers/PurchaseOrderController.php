<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * List Purchase Orders
     */
    public function index()
    {
        $data = PurchaseOrder::with('items.barang')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('purchasing.po.index', compact('data'));
    }

    /**
     * Create PO (dengan optional PR)
     */
    public function create($prId = null)
    {
        $pr = PurchaseRequest::with('items.barang')->find($prId);
        $barang = Barang::all();

        return view('purchasing.po.create', compact('pr', 'barang'));
    }

    /**
     * Store PO
     */
    public function store(Request $request)
    {
        $request->validate([
            'po_date' => 'required|date',
            'supplier_name' => 'required|string',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:1',
        ]);

        // Generate nomor PO otomatis
        $last = PurchaseOrder::latest()->first();
        $nextNumber = 'PO-' . str_pad(($last?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        // Create Purchase Order
        $po = PurchaseOrder::create([
            'po_number' => $nextNumber,
            'po_date' => $request->po_date,
            'purchase_request_id' => $request->purchase_request_id,
            'supplier_name' => $request->supplier_name,
            'supplier_address' => $request->supplier_address,
            'status' => 'Open',
            'created_by' => auth()->id(),
        ]);

        // Insert items
        foreach ($request->items as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'barang_id' => $item['barang_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['qty'] * $item['price'],
            ]);
        }

        return redirect()->route('po.index')
            ->with('success', 'Purchase Order berhasil dibuat!');
    }

    /**
     * Detail PO
     */
    public function show($id)
    {
        $po = PurchaseOrder::with('items.barang', 'purchaseRequest')
            ->findOrFail($id);

        return view('purchasing.po.show', compact('po'));
    }

    /**
     * Delete PO
     */
    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);

        // Hapus item juga
        PurchaseOrderItem::where('purchase_order_id', $po->id)->delete();

        $po->delete();

        return back()->with('success', 'Purchase Order berhasil dihapus');
    }

    /**
     * Close PO (opsional)
     */
    public function close($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->status = 'Closed';
        $po->save();

        return back()->with('success', 'Purchase Order berhasil ditutup');
    }
}
