<?php

namespace App\Http\Controllers;

use App\ProductAttributes;

class SellerProductAttributeController extends Controller
{
    public function index()
    {
        $pattr = ProductAttributes::all();
        return view('seller.product.attributes', compact('pattr'));
    }
}
