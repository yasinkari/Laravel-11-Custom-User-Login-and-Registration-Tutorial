<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tone;
use App\Models\ProductColor;
use App\Models\ToneCollection;
use App\Models\VariantImage;
use App\Models\ProductSizing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'variants.color',
            'variants.tones',
            'variants.productSizings',
            'variants.variantImages',
            'promotions' => function($query) {
                $query->where('is_active', true)
                      ->where('start_date', '<=', now())
                      ->where(function($q) {
                          $q->where('end_date', '>=', now())
                            ->orWhereNull('end_date');
                      });
            }
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    
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
            'Baju Melayu',
            'Kurta',
            'Songkok',
            'Sampin',
            'Shirt'
        ];

        return view('admin.product.create', compact('tones', 'colors', 'colorSuggestions', 'productTypes'));
    }
    
    public function store(Request $request)
    {
        // Base validation for all products
        $baseValidation = [
            'product_name' => 'required|string|max:255',
            'product_price' => 'nullable|numeric|min:0',
            'actual_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_type' => 'required|string|max:50',
            'size_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        // Add variant validation only for Baju Melayu and Sampin
        if ($request->product_type === 'Baju Melayu' || $request->product_type === 'Sampin') {
            $variantValidation = [
                'variants' => 'required|array|min:1',
                'variants.*.colorID' => 'required|exists:product_colors,colorID',
                'variants.*.tones' => 'required|array|min:1',
                'variants.*.tones.*' => 'required|exists:tones,toneID',
                'variants.*.sizes' => 'required|array|min:1',
                'variants.*.sizes.*.size' => 'required|string|max:10',
                'variants.*.sizes.*.stock' => 'required|integer|min:0',
                'variants.*.images' => 'required|array|min:1',
                'variants.*.images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            $validated = $request->validate(array_merge($baseValidation, $variantValidation));
        } else {
            $validated = $request->validate($baseValidation);
        }

        DB::beginTransaction();
        try {
            // Create the product
            $product = Product::create([
                'product_name' => $request->product_name,
                'product_price' => $request->product_price,
                'actual_price' => $request->actual_price,
                'product_description' => $request->product_description,
                'product_type' => $request->product_type,
                'is_visible' => $request->has('is_visible'),
                'size_img' => $request->file('size_img') ? $request->file('size_img')->store('size_charts', 'public') : null,
            ]);
    
            // Process variants if product type requires them
            if ($request->product_type === 'Baju Melayu' || $request->product_type === 'Sampin') {
                foreach ($request->variants as $variantData) {
                    // Create product variant
                    $variant = ProductVariant::create([
                        'productID' => $product->productID,
                        'colorID' => $variantData['colorID'],
                    ]);
    
                    // Create tone collections
                    foreach ($variantData['tones'] as $toneID) {
                        ToneCollection::create([
                            'toneID' => $toneID,
                            'product_variantID' => $variant->product_variantID,
                        ]);
                    }
    
                    // Create product sizes
                    foreach ($variantData['sizes'] as $sizeData) {
                        ProductSizing::create([
                            'product_variantID' => $variant->product_variantID,
                            'product_size' => $sizeData['size'],
                            'product_stock' => $sizeData['stock'],
                        ]);
                    }
    
                    // Store variant images
                    foreach ($variantData['images'] as $image) {
                        $imagePath = $image->store('variant_images', 'public');                        
                        VariantImage::create([
                            'product_variantID' => $variant->product_variantID,
                            'product_image' => $imagePath,
                        ]);
                    }
                }
            }
    
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
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
        
        // Define product types for dropdown
        $productTypes = [
            'Baju Melayu',
            'Kurta',
            'Songkok',
            'Sampin',
            'Shirt'
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
            Storage::disk('public')->delete($variant->image); // Changed from product_image to image
            $validatedData['image'] = $request->file('product_image')
                ->store('product_images', 'public');
        }
    
        $variant->update($validatedData);
        return redirect()->back()->with('success', 'Variant updated successfully');
    }
    
    public function destroyVariant(ProductVariant $variant)
    {
        try {
            // Changed from product_image to image
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->delete();
            return redirect()->back()->with('success', 'Variant deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting variant: ' . $e->getMessage());
        }
    }
    
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
    
            foreach ($product->variants as $variant) {
                // Changed from product_image to image
                if ($variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }
                $variant->delete();
            }
    
            $product->delete();
    
            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    // Update the showToCustomer method to only show visible products
    public function showToCustomer()
    {
        $products = Product::with(['variants.tone', 'variants.color'])
            ->where('is_visible', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('customer.products.index', compact('products'));
    }

    // Update the showProductDetails method to check visibility
    public function showProductDetails(Product $product)
    {
        if (!$product->is_visible) {
            abort(404);
        }
        
        $product->load(['variants.tone', 'variants.color']);
        
        // Get related products (same type)
        $relatedProducts = Product::where('product_type', $product->product_type)
            ->where('is_visible', true)
            ->where('productID', '!=', $product->productID)
            ->limit(4)
            ->get();
        
        // Structure the data array
        $data = [
            'product' => $product,
            'tones' => $product->variants->groupBy('tone.tone_id')->map(function ($variants) {
                $firstVariant = $variants->first();
                return [
                    'tone_id' => $firstVariant->tone->toneID,
                    'tone_name' => $firstVariant->tone->tone_name,
                    'tone_code' => $firstVariant->tone->tone_code,
                    'colors' => $variants->groupBy('color.colorID')->map(function ($colorVariants) {
                        $firstColorVariant = $colorVariants->first();
                        return [
                            'color_id' => $firstColorVariant->color->colorID,
                            'color_name' => $firstColorVariant->color->color_name,
                            'color_code' => $firstColorVariant->color->color_code,
                            'sizes' => $colorVariants->map(function ($variant) {
                                return [
                                    'variant_id' => $variant->product_variantID,
                                    'size_name' => $variant->product_size,
                                    'product_stock' => $variant->product_stock,
                                    'product_image' => $variant->product_image
                                ];
                            })->values()
                        ];
                    })->values()
                ];
            })->values()
        ];
        
        return view('customer.products.product_view', compact('data', 'product', 'relatedProducts'));
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
                'product_image' => $imagePath, // Changed from 'product_image' to 'image'
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
