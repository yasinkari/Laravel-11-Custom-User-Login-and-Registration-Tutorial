<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tone;
use App\Models\ProductColor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variants')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $tones = Tone::all();
        $colors = ProductColor::all();
        return view('admin.product.create', compact('tones', 'colors'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric',
                'product_description' => 'required|string',
                'variants' => 'required|array|min:1',
                'variants.*.toneID' => 'required|exists:tones,toneID',
                'variants.*.colorID' => 'required|exists:product_colors,colorID',
                'variants.*.product_size' => 'required|in:XS,S,M,L,XL,XXL',
                'variants.*.product_stock' => 'required|integer|min:0',
                'variants.*.product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            DB::beginTransaction();
            
            try {
                $product = Product::create([
                    'product_name' => $validatedData['product_name'],
                    'product_price' => $validatedData['product_price'],
                    'product_description' => $validatedData['product_description'],
                    'product_stock' => array_sum(array_column($validatedData['variants'], 'product_stock')),
                    
                ]);
                
                foreach ($validatedData['variants'] as $variantData) {
                    $imagePath = $variantData['product_image']->store('variant_images', 'public');
                    
                    ProductVariant::create([
                        'productID' => $product->productID,
                        'toneID' => $variantData['toneID'],
                        'colorID' => $variantData['colorID'],
                        'product_size' => $variantData['product_size'],
                        'product_stock' => $variantData['product_stock'],
                        'product_image' => $imagePath,
                    ]);
                }
                
                DB::commit();
                return redirect()->route('products.index')->with('success', 'Product and variants added successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $product->load('variants.tone', 'variants.color');
        $tones = Tone::all();
        $colors = ProductColor::all();
        return view('admin.product.edit', compact('product', 'tones', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string'
        ]);
    
        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function editVariant(ProductVariant $variant)
    {
        return response()->json($variant->load('tone', 'color'));
    }

    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $validatedData = $request->validate([
            'toneID' => 'required|exists:tones,toneID',
            'colorID' => 'required|exists:product_colors,colorID',
            'product_size' => 'required|in:XS,S,M,L,XL,XXL',
            'product_stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('product_image')) {
            Storage::delete($variant->product_image);
            $validatedData['product_image'] = $request->file('product_image')->store('product_images', 'public');
        }
    
        $variant->update($validatedData);
        return response()->json(['success' => true]);
    }

    public function destroyVariant(ProductVariant $variant)
    {
        Storage::delete($variant->product_image);
        $variant->delete();
        return response()->json(['success' => true]);
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            
            foreach ($product->variants as $variant) {
                Storage::disk('public')->delete($variant->product_image);
                $variant->delete();
            }
            
            $product->delete();
            
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product and all variants deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function showToCustomer()
    {
        $products = Product::with(['variants' => function($query) {
            $query->with(['tone', 'color'])->orderBy('product_stock', 'desc');
        }])->get();
        
        if ($products->isEmpty()) {
            return view('customer.products.index', ['message' => 'No products found.']);
        }
        
        return view('customer.products.index', compact('products'));
    }

    public function updateProductStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $product->update([
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_best_seller' => $request->has('is_best_seller'),
            'is_special_offer' => $request->has('is_special_offer'),
            'is_visible' => $request->has('is_visible')
        ]);
    
        return redirect()->back()->with('success', 'Product status updated successfully');
    }
}
