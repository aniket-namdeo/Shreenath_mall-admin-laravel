<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function show()
    {
        $page_name = 'product/add';
        $current_page = 'add-product';
        $page_title = 'Add Product';
        $categoryList = Category::where(array('status' => 1))->whereNotNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'categoryList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'mrp' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'category_id' => 'required|exists:category,id',
            'sku' => 'required|string|unique:product,sku',
            'stock' => 'required|integer',
            'product_code' => 'nullable|string',
            'pack_size' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_url1')) {
            $imageName = time() . '_image.' . $request->image_url1->extension();
            $request->image_url1->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url1'] = $full_path;
        }
        if ($request->hasFile('image_url2')) {
            $imageName = time() . '_image.' . $request->image_url2->extension();
            $request->image_url2->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url2'] = $full_path;
        }
        if ($request->hasFile('image_url3')) {
            $imageName = time() . '_image.' . $request->image_url3->extension();
            $request->image_url3->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url3'] = $full_path;
        }
        if ($request->hasFile('image_url4')) {
            $imageName = time() . '_image.' . $request->image_url4->extension();
            $request->image_url4->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url4'] = $full_path;
        }

        if ($validated) {
            $product = Product::create($validated);
            return redirect()->route('product-list.show')->with('success', 'Product created');
        }
    }

    public function productlist()
    {
        $page_name = 'product/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = Product::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function productEdit($id)
    {
        $page_name = "product/edit";
        $page_title = "Manage Product";
        $current_page = "product";
        $details = Product::find($id);
        $categoryList = Category::where(array('status' => 1))->whereNotNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        if (!$details) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'categoryList'));
    }


    public function productUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'mrp' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'category_id' => 'required|exists:category,id',
            'sku' => 'required|string|unique:product,sku,' . $id,
            'stock' => 'required|integer',
            'brand' => 'nullable|string',
            'product_code' => 'nullable|string',
            'pack_size' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_url1')) {
            $imageName = time() . '_image.' . $request->image_url1->extension();
            $request->image_url1->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url1'] = $full_path;
        }
        if ($request->hasFile('image_url2')) {
            $imageName = time() . '_image.' . $request->image_url2->extension();
            $request->image_url2->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url2'] = $full_path;
        }
        if ($request->hasFile('image_url3')) {
            $imageName = time() . '_image.' . $request->image_url3->extension();
            $request->image_url3->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url3'] = $full_path;
        }
        if ($request->hasFile('image_url4')) {
            $imageName = time() . '_image.' . $request->image_url4->extension();
            $request->image_url4->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url4'] = $full_path;
        }

        if ($validated) {

            $product = Product::find($id);

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $product->update($request->all());

            if ($product) {
                return redirect()->route('product-list.show')->with('success', 'Product updated');
            } else {
                return redirect()->back()->with('error', 'Something went Wrong');
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $product->delete();
        return redirect()->route('product-list.show')->with('success', 'Product deleted successfully.');
    }



    public function bulkUploadProducts(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $csvPath = $request->file('csv_file')->getRealPath();
        $csvData = array_map('str_getcsv', file($csvPath));

        foreach ($csvData as $row) {
            // Assuming your CSV columns are in the following order:
            $productData = [
                'product_name' => $row[0],
                'description' => $row[1],
                'price' => $row[2],
                'mrp' => $row[3],
                'discount_percent' => $row[4],
                'category_id' => $row[5],
                'sku' => $row[6],
                'stock' => $row[7],
                'product_code' => $row[8],
                'pack_size' => $row[9],
                // Add other fields as needed
            ];


            Product::updateOrCreate(['sku' => $productData['sku']], $productData);
        }

        return redirect()->route('product-list.show')->with('success', 'Products imported successfully');
    }
}
