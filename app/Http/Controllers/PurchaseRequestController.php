<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Barang;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    /**
     * List PR
     */
    public function index()
    {
        $data = PurchaseRequest::with('items.barang')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('purchasing.pr.index', compact('data'));
    }

    /**
     * Form Create PR
     */
    public function create()
    {
        $barang = Barang::all();
        return view('purchasing.pr.create', compact('barang'));
    }

    /**
     * Store PR
     */
    public function store(Request $request)
    {
        $request->validate([
            'pr_date' => 'required|date',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty'      => 'required|integer|min:1',
        ]);

        // Generate nomor PR otomatis
        $last = PurchaseRequest::latest()->first();
        $nextNumber = 'PR-' . str_pad(($last?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $pr = PurchaseRequest::create([
            'pr_number'   => $nextNumber,
            'pr_date'     => $request->pr_date,
            'created_by'  => auth()->id(),
            'requester'   => auth()->user()->nama ?? 'Unknown',
            'status'      => 'Pending',
        ]);

        // Insert item PR
        foreach ($request->items as $item) {
            PurchaseRequestItem::create([
                'purchase_request_id' => $pr->id,
                'barang_id' => $item['barang_id'],
                'qty'       => $item['qty'],
                'unit'      => $item['unit'] ?? 'pcs',
            ]);
        }

        return redirect()->route('pr.index')
            ->with('success', 'Purchase Request berhasil dibuat!');
    }

    /**
     * Detail PR
     */
    public function show($id)
    {
        $pr = PurchaseRequest::with('items.barang', 'creator', 'approver')
            ->findOrFail($id);

        return view('purchasing.pr.show', compact('pr'));
    }

    /**
     * Delete PR
     */
    public function destroy($id)
    {
        $pr = PurchaseRequest::findOrFail($id);

        PurchaseRequestItem::where('purchase_request_id', $pr->id)->delete();
        $pr->delete();

        return back()->with('success', 'Purchase Request berhasil dihapus');
    }

    /**
     * APPROVAL — Supervisor approve PR
     */
    public function approve($id)
    {
        $pr = PurchaseRequest::findOrFail($id);

        $pr->update([
            'status'      => 'Approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Purchase Request disetujui!');
    }

    /**
     * APPROVAL — Supervisor reject PR
     */
    public function reject($id)
    {
        $pr = PurchaseRequest::findOrFail($id);

        $pr->update([
            'status'      => 'Rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Purchase Request ditolak!');
    }
}
