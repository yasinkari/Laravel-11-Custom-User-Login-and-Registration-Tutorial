<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Color;
use App\Models\Product;
<<<<<<< HEAD

=======
use App\Models\ProductVariant;
use App\Models\Tone;
use App\Models\ProductColor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
>>>>>>> master

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
<<<<<<< HEAD
        return view('admin.product.create');
=======
        $tones = Tone::all();
        $colors = ProductColor::all();
        return view('admin.product.create', compact('tones', 'colors'));
>>>>>>> master
    }

    // Store the new product in the database
    public function store(Request $request)
    {
<<<<<<< HEAD
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'variants' => 'required|array',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.size' => 'required|string|max:10',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        // Handle the image upload (for product image)
        $productImagePath = $request->file('image')->store('product_images', 'public');

        // Prepare the variants data (for the 'details' JSON)
        $variants = [];
        foreach ($request->variants as $variant) {
            $variants[] = [
                'color' => $variant['color'],
                'size' => $variant['size'],
                'stock' => $variant['stock'],
            ];
        }

        // Create the product
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $productImagePath,  // Save the product image path
            'details' => ['variants' => $variants],  // Save the variants in the JSON column
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }
  

     // Toggle product visibility
     public function toggleVisibility(Product $product)
     {
         $product->is_visible = !$product->is_visible; // Toggle visibility
         $product->save();
 
         return redirect()->route('products.index')->with('success', 'Product visibility updated successfully');
     }
 
    // Toggle product status
    public function toggleStatus(Product $product)
    {
        // Cycle through the product status based on the current status
        $statusOrder = ['in_stock', 'low_stock', 'out_of_stock'];
        $currentStatusIndex = array_search($product->status, $statusOrder);
        $nextStatusIndex = ($currentStatusIndex + 1) % count($statusOrder); // Loop back to the first status if at the end

        // Update the status
        $product->status = $statusOrder[$nextStatusIndex];
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product status updated successfully');
    }


    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
=======
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
                // Create the main product
                $product = Product::create([
                    'product_name' => $validatedData['product_name'],
                    'product_price' => $validatedData['product_price'],
                    'product_description' => $validatedData['product_description'],
                    'product_stock' => array_sum(array_column($validatedData['variants'], 'product_stock')),
                ]);
                
                // Create variants
                foreach ($validatedData['variants'] as $variantData) {
                    // Handle variant image upload
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
                
                return redirect()->route('products.index')
                    ->with('success', 'Product and variants added successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('Error creating product: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to add product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Product $product)
    {
        $product->load('variants.tone', 'variants.color');
        $tones = Tone::all();
        $colors = ProductColor::all();
        return view('admin.product.edit', compact('product', 'tones', 'colors'));
>>>>>>> master
    }

    public function update(Request $request, Product $product)
    {
<<<<<<< HEAD
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'variants' => 'required|array',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.size' => 'required|string|max:10',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        // Handle the product image upload (if new image is uploaded)
        if ($request->hasFile('image')) {
            $productImagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $productImagePath;
        }

        // Prepare the variants data (for the 'details' JSON)
        $variants = [];
        foreach ($request->variants as $variant) {
            $variants[] = [
                'color' => $variant['color'],
                'size' => $variant['size'],
                'stock' => $variant['stock'],
            ];
        }

        // Update the product
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'details' => ['variants' => $variants],  // Update variants in the JSON column
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

=======
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
>>>>>>> master

    //delete
    public function destroy(Product $product)
    {
<<<<<<< HEAD
        // Optionally delete images if needed
        // unlink(storage_path('app/public/' . $product->image));
        // foreach ($product->details['variants'] as $variant) {
        //     unlink(storage_path('app/public/' . $variant['image']));
        // }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }


    //customer display
    public function showToCustomer()
    {
        // Retrieve all visible products
        $products = Product::where('is_visible', true)->get();
    
=======
        try {
            DB::beginTransaction();
            
            try {
                // Delete associated image if exists
                if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
                    Storage::disk('public')->delete($product->product_image);
                }
                
                // Delete all variants
                $product->variants()->delete();
                
                // Delete the product
                $product->delete();
                
                DB::commit();
                
                return redirect()->route('products.index')
                    ->with('success', 'Product and all variants deleted successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting product: ' . $e->getMessage());
            
            return redirect()->route('products.index')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    //customer display
    public function showToCustomer()
    {
        // Retrieve all products with their variants
        $products = Product::with('variants')->get();
        
>>>>>>> master
        // Debugging: Check the query result
        if ($products->isEmpty()) {
            return view('customer.products.index', ['message' => 'No products found.']);
        }
<<<<<<< HEAD
    
        // Pass products to the view
        return view('customer.products.index', compact('products'));
    }
    

=======
        
        // Pass products to the view
        return view('customer.products.index', compact('products'));
    }

    public function updateProductStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $product->update([
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_best_seller' => $request->has('is_best_seller'),
            'is_special_offer' => $request->has('is_special_offer')
        ]);
    
        return redirect()->back()->with('success', 'Product status updated successfully');
    }
    
    public function getNewArrivals()
    {
        return Product::where('is_new_arrival', true)->get();
    }
    
    public function getBestSellers()
    {
        return Product::where('is_best_seller', true)->get();
    }
    
    public function getSpecialOffers()
    {
        return Product::where('is_special_offer', true)->get();
    }
>>>>>>> master
}
