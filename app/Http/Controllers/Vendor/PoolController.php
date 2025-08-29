<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    public function index(Request $r)
    {
        $vendorId = (int) auth()->user()->vendor_id;

        $q = Product::visibleToVendor($vendorId)->with('brand');

        if ($r->filled('source')) $q->where('source', $r->string('source'));
        if ($r->filled('status')) $q->where('pool_status', $r->string('status'));

        return response()->json($q->latest()->paginate(20));
    }

    public function store(Request $r)
    {
        $vendorId = (int) auth()->user()->vendor_id;

        $data = $r->validate([
            'name'        => 'required|string|max:255',
            'unit_price'  => 'required|numeric',
            'brand_id'    => 'nullable|integer',
            'category_id' => 'nullable|integer',
        ]);

        $data += [
            'added_by'             => 'seller',
            'user_id'              => auth()->id(),
            'is_pool'              => true,
            'source'               => 'manual',
            'pool_status'          => 'pending',
            'created_by_vendor_id' => $vendorId,
            'status'               => 1,
            'request_status'       => 1,
            'product_type'         => 'physical',
        ];

        return response()->json(Product::create($data), 201);
    }
}
