<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;
use App\Models\PromotionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    /**
     * Display a listing of the promotions.
     */
    public function index()
    {
        $promotions = Promotion::with('products')
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
            
        $promotionTypes = [
            'discount' => 'Discount (% off)',
            'bundle' => 'Bundle (Buy multiple for discount)',
            'clearance' => 'Clearance Sale',
            'seasonal' => 'Seasonal Promotion'
        ];
            
        return view('admin.promotions.create', compact('products', 'promotionTypes'));
    }

    /**
     * Store a newly created promotion in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Starting promotion creation process', ['request_data' => $request->except('_token')]);
            
            $validatedData = $request->validate([
                'promotion_name' => 'required|string|max:255',
                'promotion_type' => 'required|string|in:discount,bundle,clearance,seasonal',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'products' => 'required|array',
                'products.*' => 'exists:products,productID',
            ]);
            
            Log::info('Validation passed for promotion creation', ['validated_data' => $validatedData]);
    
            DB::beginTransaction();
            Log::info('DB transaction started for promotion creation');
    
            // Create the promotion
            $promotion = Promotion::create([
                'promotion_name' => $validatedData['promotion_name'],
                'promotion_type' => $validatedData['promotion_type'],
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);
            
            Log::info('Promotion created successfully', ['promotion_id' => $promotion->promotionID]);
            
            // Associate products with the promotion
            if (isset($validatedData['products'])) {
                Log::info('Adding products to promotion', ['product_count' => count($validatedData['products'])]);
                
                foreach ($validatedData['products'] as $productId) {
                    PromotionRecord::create([
                        'promotionID' => $promotion->promotionID,
                        'productID' => $productId
                    ]);
                    
                    Log::debug('Product added to promotion', [
                        'promotion_id' => $promotion->promotionID,
                        'product_id' => $productId
                    ]);
                }
            }
    
            DB::commit();
            Log::info('DB transaction committed for promotion creation', ['promotion_id' => $promotion->promotionID]);
            
            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promotion created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create promotion', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token')
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Failed to create promotion: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified promotion.
     */
    public function show(Promotion $promotion)
    {
        $promotion->load('products');
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
            'clearance' => 'Clearance Sale',
            'seasonal' => 'Seasonal Promotion'
        ];
        
        // Get IDs of products associated with this promotion
        $selectedProducts = $promotion->products->pluck('productID')->toArray();
        
        return view('admin.promotions.edit', compact('promotion', 'products', 'promotionTypes', 'selectedProducts'));
    }

    /**
     * Update the specified promotion in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        try {
            Log::info('Starting promotion update process', [
                'promotion_id' => $promotion->promotionID,
                'request_data' => $request->except('_token', '_method')
            ]);
            
            $validatedData = $request->validate([
                'promotion_name' => 'required|string|max:255',
                'promotion_type' => 'required|string|in:discount,bundle,clearance,seasonal',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'products' => 'required|array',
                'products.*' => 'exists:products,productID',
            ]);
            
            Log::info('Validation passed for promotion update', [
                'promotion_id' => $promotion->promotionID,
                'validated_data' => $validatedData
            ]);
    
            DB::beginTransaction();
            Log::info('DB transaction started for promotion update', ['promotion_id' => $promotion->promotionID]);
    
            // Update the promotion
            $oldData = $promotion->toArray();
            
            $promotion->update([
                'promotion_name' => $validatedData['promotion_name'],
                'promotion_type' => $validatedData['promotion_type'],
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);
            
            Log::info('Promotion updated successfully', [
                'promotion_id' => $promotion->promotionID,
                'old_data' => $oldData,
                'new_data' => $promotion->toArray()
            ]);
            
            // Remove all existing product associations
            $oldProductCount = PromotionRecord::where('promotionID', $promotion->promotionID)->count();
            PromotionRecord::where('promotionID', $promotion->promotionID)->delete();
            
            Log::info('Removed existing product associations', [
                'promotion_id' => $promotion->promotionID,
                'removed_product_count' => $oldProductCount
            ]);
            
            // Add new product associations
            if (isset($validatedData['products'])) {
                Log::info('Adding updated products to promotion', [
                    'promotion_id' => $promotion->promotionID,
                    'product_count' => count($validatedData['products'])
                ]);
                
                foreach ($validatedData['products'] as $productId) {
                    PromotionRecord::create([
                        'promotionID' => $promotion->promotionID,
                        'productID' => $productId
                    ]);
                    
                    Log::debug('Product added to promotion during update', [
                        'promotion_id' => $promotion->promotionID,
                        'product_id' => $productId
                    ]);
                }
            }
    
            DB::commit();
            Log::info('DB transaction committed for promotion update', ['promotion_id' => $promotion->promotionID]);
            
            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promotion updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update promotion', [
                'promotion_id' => $promotion->promotionID,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->except('_token', '_method')
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Failed to update promotion: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified promotion from storage.
     */
    public function destroy(Promotion $promotion)
    {
        try {
            DB::beginTransaction();
            
            // Delete associated promotion records first
            PromotionRecord::where('promotionID', $promotion->promotionID)->delete();
            
            // Then delete the promotion
            $promotion->delete();
            
            DB::commit();
            
            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promotion deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete promotion: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete promotion: ' . $e->getMessage()]);
        }
    }
}