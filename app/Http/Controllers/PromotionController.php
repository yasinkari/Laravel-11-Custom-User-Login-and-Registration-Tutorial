<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the promotions.
     */
    public function index()
    {
        $promotions = Promotion::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new promotion.
     */
    public function create()
    {
        $products = Product::where('is_visible', true)
            ->orderBy('product_name')
            ->get();
            
        return view('admin.promotions.create', compact('products'));
    }

    /**
     * Store a newly created promotion in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'productID' => 'required|exists:products,productID',
                'promotion_name' => 'required|string|max:255',
                'promotion_type' => 'required|string|max:50',
            ]);
    
            DB::beginTransaction();
    
            Promotion::create($validatedData);
    
            DB::commit();
            return redirect()->route('promotions.index')
                ->with('success', 'Promotion created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating promotion: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified promotion.
     */
    public function show(Promotion $promotion)
    {
        $promotion->load('product');
        
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified promotion.
     */
    public function edit(Promotion $promotion)
    {
        $products = Product::where('is_visible', true)
            ->orderBy('product_name')
            ->get();
            
        $promotionTypes = [
            'discount' => 'Discount',
            'bundle' => 'Bundle Deal',
            'clearance' => 'Clearance Sale',
            'seasonal' => 'Seasonal Offer',
            'limited' => 'Limited Edition'
        ];
        
        return view('admin.promotions.edit', compact('promotion', 'products', 'promotionTypes'));
    }

    /**
     * Update the specified promotion in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        try {
            $validatedData = $request->validate([
                'productID' => 'required|exists:products,productID',
                'promotion_name' => 'required|string|max:255',
                'promotion_type' => 'required|string|max:50',
            ]);
    
            DB::beginTransaction();
    
            $promotion->update($validatedData);
    
            DB::commit();
            return redirect()->route('promotions.index')
                ->with('success', 'Promotion updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating promotion: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified promotion from storage.
     */
    public function destroy(Promotion $promotion)
    {
        try {
            DB::beginTransaction();
            
            $promotion->delete();
            
            DB::commit();
            return redirect()->route('promotions.index')
                ->with('success', 'Promotion deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('promotions.index')
                ->with('error', 'Error deleting promotion: ' . $e->getMessage());
        }
    }
    
    /**
     * Display active promotions to customers.
     */
    public function showToCustomer()
    {
        $promotions = Promotion::with(['product' => function($query) {
            $query->where('is_visible', true);
        }])
        ->whereHas('product', function($query) {
            $query->where('is_visible', true);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('customer.promotions.index', compact('promotions'));
    }
}