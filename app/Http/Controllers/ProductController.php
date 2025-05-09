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

        // Define product types for dropdown
        $productTypes = [
            'Lipstick',
            'Foundation',
            'Eyeshadow',
            'Mascara',
            'Blush',
            'Eyeliner',
            'Concealer',
            'Powder',
            'Primer',
            'Other'
        ];

        return view('admin.product.create', compact('tones', 'colors', 'colorSuggestions', 'productTypes'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'nullable|numeric|min:0',
            'actual_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_type' => 'required|string|max:50',
            'variants' => 'required|array|min:1',
            'variants.*.toneID' => 'required|exists:tones,toneID',
            'variants.*.colorID' => 'required|exists:product_colors,colorID',
            'variants.*.product_size' => 'required|string|max:10',
            'variants.*.product_stock' => 'required|integer|min:0',
            'variants.*.product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the product
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'actual_price' => $request->actual_price,
            'product_description' => $request->product_description,
            'product_type' => $request->product_type,
            'is_visible' => $request->has('is_visible') ? 1 : 0,
        ]);

        // Create variants
        foreach ($validated['variants'] as $variantData) {
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
        
        // Define product types for dropdown
        $productTypes = [
            'Lipstick',
            'Foundation',
            'Eyeshadow',
            'Mascara',
            'Blush',
            'Eyeliner',
            'Concealer',
            'Powder',
            'Primer',
            'Other'
        ];
        
        return view('admin.product.edit', compact('product', 'variants', 'tones', 'colors', 'productTypes'));
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
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'nullable|numeric|min:0',
            'actual_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_type' => 'required|string|max:50',
        ]);
    
        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'actual_price' => $request->actual_price,
            'product_description' => $request->product_description,
            'product_type' => $request->product_type,
            'is_visible' => $request->has('is_visible') ? 1 : 0,
        ]);
    
        return redirect()->route('products.edit', $product->productID)
            ->with('success', 'Product information updated successfully');
    }
    
    /**
     * Update product visibility status
     */
    public function updateVisibility(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_visible = $request->is_visible;
        $product->save();
        
        return response()->json(['success' => true]);
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

    // Update the showToCustomer method to only show visible products
    public function showToCustomer()
    {
        $products = Product::where('is_visible', true)
            ->with(['variants' => function($query) {
                $query->with(['tone', 'color'])->orderBy('product_stock', 'desc');
            }])
            ->paginate(12);
        
        // Get unique product types for filtering
        $productTypes = Product::where('is_visible', true)
            ->distinct()
            ->whereNotNull('product_type')
            ->pluck('product_type');
        
        if ($products->isEmpty()) {
            return view('customer.products.index', ['message' => 'No products found.']);
        }
        
        return view('customer.products.index', compact('products', 'productTypes'));
    }

    // Update the showProductDetails method to check visibility
    public function showProductDetails(Product $product)
    {
        // Check if product is visible
        if (!$product->is_visible) {
            return redirect()->route('products.customer')
                ->with('error', 'This product is currently unavailable.');
        }

        $product->load(['variants' => function($query) {
            $query->with(['tone', 'color'])
                ->orderBy('product_stock', 'desc');
        }]);
        
        // Create a structured data array with product info, tones, colors, and sizes
        $data = [
            'product' => [
                'productID' => $product->productID,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_description' => $product->product_description,
                'is_new_arrival' => $product->is_new_arrival ?? false,
                'is_best_seller' => $product->is_best_seller ?? false,
                'is_special_offer' => $product->is_special_offer ?? false,
                'is_visible' => $product->is_visible ?? true,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ],
            'tones' => []
        ];
        
        foreach ($product->variants as $variant) {
            $toneID = $variant->toneID;
            $colorID = $variant->colorID;
            $size = $variant->product_size;
            
            // Initialize tone if it doesn't exist in data array
            if (!isset($data['tones'][$toneID])) {
                $data['tones'][$toneID] = [
                    'tone_id' => $toneID,
                    'tone_name' => $variant->tone->tone_name,
                    'tone_code' => $variant->tone->tone_code,
                    'colors' => []
                ];
            }
            
            // Initialize color if it doesn't exist in this tone's colors
            if (!isset($data['tones'][$toneID]['colors'][$colorID])) {
                $data['tones'][$toneID]['colors'][$colorID] = [
                    'color_id' => $colorID,
                    'color_name' => $variant->color->color_name,
                    'color_code' => $variant->color->color_code,
                    'sizes' => []
                ];
            }
            
            // Add size information
            $data['tones'][$toneID]['colors'][$colorID]['sizes'][$size] = [
                'product_size' => $size,
                'product_image' => $variant->product_image,
                'product_stock' => $variant->product_stock,
                'product_variantID' => $variant->product_variantID
            ];
        }
        
        // Convert associative arrays to indexed arrays for easier iteration in the view
        foreach ($data['tones'] as &$tone) {
            $tone['colors'] = array_values($tone['colors']);
            
            foreach ($tone['colors'] as &$color) {
                // Sort sizes in a standard order (XS, S, M, L, XL, XXL)
                $sizeOrder = ['XS' => 0, 'S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                
                // Convert sizes to array and sort
                $sizesArray = [];
                foreach ($color['sizes'] as $sizeKey => $sizeData) {
                    $sizeData['size_name'] = $sizeKey; // Add size name for easier access
                    $sizesArray[] = $sizeData;
                }
                
                // Sort by the predefined order
                usort($sizesArray, function($a, $b) use ($sizeOrder) {
                    return $sizeOrder[$a['size_name']] - $sizeOrder[$b['size_name']];
                });
                
                $color['sizes'] = $sizesArray;
            }
        }
        
        // Convert tones to indexed array
        $data['tones'] = array_values($data['tones']);
        
        // Pass only the structured data to the view
        return view('customer.products.product_view', compact('data'));
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
