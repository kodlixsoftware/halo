<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPoolController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::pool()->with(['brand','vendor']);

        if ($r->filled('source')) $q->where('source', $r->string('source'));
        if ($r->filled('status')) $q->where('pool_status', $r->string('status'));

        return response()->json($q->latest()->paginate(20));
    }

    public function approve(Product $product)
    {
        $product->update(['pool_status' => 'approved']);
        return response()->json(['ok'=>true]);
    }
}
