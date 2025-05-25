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
        $product->load(['variants.variantImages']);
        return view('admin.product.edit', compact('product'));
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
            'product_price' => 'required|numeric|min:0',
            'actual_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'product_type' => 'required|string|max:50',
            'size_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variant_imageID' => 'nullable|exists:variant_image,variant_imageID'
        ]);
    
        try {
            $updateData = [
                'product_name' => $request->product_name,
                'product_price' => $request->product_price,
                'actual_price' => $request->actual_price,
                'product_description' => $request->product_description,
                'product_type' => $request->product_type,
                'is_visible' => $request->has('is_visible') ? 1 : 0,
                'variant_imageID' => $request->variant_imageID
            ];
        
            if ($request->hasFile('size_img')) {
                // Delete old image if exists
                if ($product->size_img) {
                    Storage::delete($product->size_img);
                }
                
                // Store new image
                $path = $request->file('size_img')->store('public/size_charts');
                $updateData['size_img'] = str_replace('public/', '', $path);
            }
            
            $product->update($updateData);

            return redirect()->route('products.edit', $product->productID)
                ->with('success', 'Product information updated successfully');

        } catch (\Exception $e) {
            return redirect()->route('products.edit', $product->productID)
                ->with('error', 'Failed to update product. Please try again.')
                ->withInput();
        }
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
            'colorID' => 'required|exists:product_colors,colorID',
            'tones' => 'required|array',
            'tones.*' => 'exists:tones,toneID',
            'sizes' => 'required|array',
            'sizes.*' => 'required|in:XS,S,M,L,XL',
            'stocks' => 'required|array',
            'stocks.*' => 'required|integer|min:0',
            'sizing_ids' => 'array',
            'sizing_ids.*' => 'exists:product_sizing,product_sizingID',
            'new_sizes' => 'array',
            'new_sizes.*' => 'in:XS,S,M,L,XL',
            'new_stocks' => 'array',
            'new_stocks.*' => 'integer|min:0',
            'delete_sizing_ids' => 'array',
            'delete_sizing_ids.*' => 'exists:product_sizing,product_sizingID',
            'delete_image_ids' => 'array',
            'delete_image_ids.*' => 'exists:variant_image,variant_imageID',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Update variant color
            $variant->update(['colorID' => $validatedData['colorID']]);

            // Update tones
            $variant->tones()->sync($validatedData['tones']);

            // Handle existing sizes updates
            if (!empty($validatedData['sizing_ids'])) {
                foreach ($validatedData['sizing_ids'] as $index => $sizingId) {
                    ProductSizing::where('product_sizingID', $sizingId)
                        ->update([
                            'product_size' => $validatedData['sizes'][$index],
                            'product_stock' => $validatedData['stocks'][$index]
                        ]);
                }
            }

            // Add new sizes
            if (!empty($validatedData['new_sizes'])) {
                foreach ($validatedData['new_sizes'] as $index => $size) {
                    $variant->productSizings()->create([
                        'product_size' => $size,
                        'product_stock' => $validatedData['new_stocks'][$index]
                    ]);
                }
            }

            // Delete removed sizes
            if (!empty($validatedData['delete_sizing_ids'])) {
                ProductSizing::whereIn('product_sizingID', $validatedData['delete_sizing_ids'])
                    ->delete();
            }

            // Delete removed images
            if (!empty($validatedData['delete_image_ids'])) {
                $imagesToDelete = VariantImage::whereIn('variant_imageID', $validatedData['delete_image_ids'])
                    ->get();
                
                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->product_image);
                    $image->delete();
                }
            }

            // Add new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $path = $image->store('variant_images', 'public');
                    $variant->variantImages()->create([
                        'product_image' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Variant updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update variant: ' . $e->getMessage())
                ->withInput();
        }
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
        $products = Product::with([
            'variants.tones', 
            'variants.color', 
            'variants.productSizings',
            'variants.variantImages'
        ])->get();
        return view('customer.products.index', compact('products'));
    }

    // Update the showProductDetails method to check visibility
    public function showProductDetails(Product $product)
    {
        if (!$product->is_visible) {
            abort(404);
        }
        
        $product->load(['variants.tones', 'variants.color', 'variants.productSizings', 'variants.variantImages']);

        // Restructure the data array to match requested format
        $product_variant = [
            "product"=> [
                'variants' => $product->variants->mapWithKeys(function($variant) {
                    return [
                        $variant->product_variantID => [
                            'color_code' => $variant->color ? $variant->color->color_code : null,
                            // Include other variant properties if needed
                        ]
                    ];
                })
            ]
        ];
        // Get related products (same type)
        $relatedProducts = Product::where('product_type', $product->product_type)
            ->where('is_visible', true)
            ->where('productID', '!=', $product->productID)
            ->limit(4)
            ->get();
        
        // Restructure the data array
        $data = [];

        foreach ($product->variants as $variant) {
            $data[$variant->product_variantID] = [
                'color' => $variant->color ? $variant->color->color_code : null,
                'variant_images' => $variant->variantImages->map(function($image) {
                    return [
                        'variant_imageID' => $image->variant_imageID,
                        'product_image' => "/storage/".$image->product_image
                    ];
                })->toArray(),
                'sizings' => $variant->productSizings->map(function($sizing) {
                    return [
                        'product_sizingID' => $sizing->product_sizingID,
                        'product_stock' => $sizing->product_stock,
                        'product_size' => $sizing->product_size
                    ];
                })->toArray(),
                'tones' => $variant->tones->map(function($tone) {
                    return [
                        'tone_code' => $tone->tone_code,
                        'tone_name' => $tone->tone_name
                    ];
                })->toArray()
            ];
        }
        
        return view('customer.products.product_view', compact('data', 'product_variant', 'relatedProducts', 'product'));
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
            $variant->load(['productSizings', 'variantImages', 'color', 'tones']);
            $colors = ProductColor::all();
            $tones = Tone::all();
            
            return view('admin.product.variants.edit', [
                'variant' => $variant,
                'colors' => $colors,
                'tones' => $tones
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load variant details');
        }
    }
    
    // Add this method to your ProductController class
    public function createVariant(Product $product)
    {
        // Get all tones and colors for the variant form
        $tones = Tone::orderBy('tone_name')->get();
        $colors = ProductColor::orderBy('color_name')->get();
        
        return view('admin.product.create_variant', compact('product', 'tones', 'colors'));
    }
}
