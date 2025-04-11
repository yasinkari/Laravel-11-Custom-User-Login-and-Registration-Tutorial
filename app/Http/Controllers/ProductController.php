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
        $products = Product::with('variants')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserves other query parameters
    
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $tones = Tone::all();
        $colors = ProductColor::all();
        
        // Color suggestions based on skin tone
        $colorSuggestions = [
            'Fair' => [
                'Navy' => '#000080',
                'Brown' => '#8B4513',
                'Burgundy' => '#800020',
                'Green' => '#006400',
                'Olive' => '#808000'
            ],
            'Olive' => [
                'Burgundy' => '#800020',
                'Maroon' => '#800000',
                'Purple' => '#800080',
                'Green' => '#006400',
                'Navy' => '#000080'
            ],
            'Light Brown' => [
                'Navy' => '#000080',
                'Royal Blue' => '#4169E1',
                'Teal' => '#008080',
                'Grey' => '#808080',
                'Burgundy' => '#800020'
            ],
            'Brown' => [
                'Navy' => '#000080',
                'Mid Blue' => '#0000CD',
                'Green' => '#006400',
                'Bright Yellow' => '#FFFF00',
                'Sky Blue' => '#87CEEB'
            ],
            'Black Brown' => [
                'Black' => '#000000',
                'Navy' => '#000080',
                'Burgundy' => '#800020',
                'Pink' => '#FFC0CB',
                'Pastel Blue' => '#ADD8E6'
            ]
        ];

        return view('admin.product.create', compact('tones', 'colors', 'colorSuggestions'));
    }

    // Add these methods to your existing ProductController
    
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric|min:0',
                'product_description' => 'required|string',
                'variants' => 'required|array|min:1',
                'variants.*.toneID' => 'required|exists:tones,toneID',
                'variants.*.colorID' => 'required|exists:product_colors,colorID',
                'variants.*.product_size' => 'required|in:XS,S,M,L,XL,XXL',
                'variants.*.product_stock' => 'required|integer|min:0',
                'variants.*.product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            DB::beginTransaction();
    
            // Create product
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'product_price' => $validatedData['product_price'],
                'product_description' => $validatedData['product_description'],
            ]);
    
            // Create variants
            foreach ($validatedData['variants'] as $variantData) {
                $imagePath = $variantData['product_image']->store('product_images', 'public');
                
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
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating product: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Add these methods to your ProductController class
    
    public function edit(Product $product)
    {
        // Load the product with paginated variants
        $variants = ProductVariant::where('productID', $product->productID)
            ->with(['tone', 'color'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        // Get all tones and colors for the variant form
        $tones = Tone::orderBy('tone_name')->get();
        $colors = ProductColor::orderBy('color_name')->get();
        
        return view('admin.product.edit', compact('product', 'variants', 'tones', 'colors'));
    }
    
    // Add this new method for AJAX pagination
    public function getVariants(Product $product)
    {
        $variants = $product->variants()
            ->with(['tone', 'color'])
            ->paginate(10);
    
        if (request()->ajax()) {
            return view('admin.product.partials.variants_table', compact('variants'))->render();
        }
    
        return view('admin.product.edit', compact('product', 'variants'));
    }
    
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
        ]);
    
        $product->update($validatedData);
    
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }
    
    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $validatedData = $request->validate([
            'toneID' => 'required|exists:tones,toneID',
            'colorID' => 'required|exists:product_colors,colorID',
            'product_size' => 'required|in:XS,S,M,L,XL,XXL',
            'product_stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('product_image')) {
            Storage::disk('public')->delete($variant->product_image);
            $validatedData['product_image'] = $request->file('product_image')
                ->store('product_images', 'public');
        }
    
        $variant->update($validatedData);
        return redirect()->back()->with('success', 'Variant updated successfully');
    }
    
    public function destroyVariant(ProductVariant $variant)
    {
        try {
            Storage::disk('public')->delete($variant->product_image);
            $variant->delete();
            return redirect()->back()->with('success', 'Variant deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting variant');
        }
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
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                ->with('error', 'Error deleting product');
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
    
    // Add this method to your ProductController class
    public function showProductDetails(Product $product)
    {
        $product->load(['variants' => function($query) {
            $query->with(['tone', 'color'])
                ->orderBy('product_stock', 'desc');
        }]);
        
        return view('customer.products.product_view', compact('product'));
    }

    public function storeVariant(Request $request, $productID)
    {
        try {
            $product = Product::findOrFail($productID);
            
            $validatedData = $request->validate([
                'toneID' => 'required|exists:tones,toneID',
                'colorID' => 'required|exists:product_colors,colorID',
                'product_size' => 'required|in:XS,S,M,L,XL,XXL',
                'product_stock' => 'required|integer|min:0',
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            
            ProductVariant::create([
                'productID' => $product->productID,
                'toneID' => $validatedData['toneID'],
                'colorID' => $validatedData['colorID'],
                'product_size' => $validatedData['product_size'],
                'product_stock' => $validatedData['product_stock'],
                'product_image' => $imagePath,
            ]);
            
            return redirect()->back()->with('success', 'Variant added successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error adding variant: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Add this method after the edit() method
    public function editVariant(ProductVariant $variant)
    {
        try {
            $variant->load(['tone', 'color']);
            return response()->json([
                'variant' => [
                    'product_variantID' => $variant->product_variantID,
                    'toneID' => $variant->toneID,
                    'colorID' => $variant->colorID,
                    'product_size' => $variant->product_size,
                    'product_stock' => $variant->product_stock,
                    'product_image' => $variant->product_image
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load variant details'], 500);
        }
    }
}
