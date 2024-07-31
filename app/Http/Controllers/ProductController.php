<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            $imageName = time() . '_image1.' . $request->image_url1->extension();
            $request->image_url1->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url1'] = $full_path;
        }

        if ($request->hasFile('image_url2')) {
            $imageName = time() . '_image2.' . $request->image_url2->extension();
            $request->image_url2->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url2'] = $full_path;
        }
        if ($request->hasFile('image_url3')) {
            $imageName = time() . '_image3.' . $request->image_url3->extension();
            $request->image_url3->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url3'] = $full_path;
        }
        if ($request->hasFile('image_url4')) {
            $imageName = time() . '_image4.' . $request->image_url4->extension();
            $request->image_url4->move(public_path('uploads/products'), $imageName);
            $full_path = "uploads/products/" . $imageName;
            $validated['image_url4'] = $full_path;
        }

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $product->update($validated);

        return redirect()->route('product-list.show')->with('success', 'Product updated');
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


    public function bulkAddProduct()
    {
        $page_name = 'product/bulkUpload';
        $current_page = 'add-product';
        $page_title = 'Add Bulk Product';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        $columns = [
            'product_name',
            'description',
            'price',
            'mrp',
            'discount_percent',
            'category_id',
            'sku',
            'stock',
            'product_code',
            'pack_size'
        ];

        if ($header !== $columns) {
            return redirect()->back()->with('error', 'CSV file format is incorrect.');
        }

        while ($row = fgetcsv($file)) {
            $data = array_combine($columns, $row);

            $validator = Validator::make($data, [
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

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Product::create($validator->validated());
        }

        fclose($file);

        return redirect()->route('product-list.show')->with('success', 'Products uploaded successfully');
    }

    public function downloadSampleFile()
    {
        $columns = [
            'product_name',
            'description',
            'price',
            'mrp',
            'discount_percent',
            'category_id',
            'sku',
            'stock',
            'product_code',
            'pack_size'
        ];

        $sampleData = [
            [
                'Sample Product',
                'This is a sample product description',
                '100',
                '120',
                '20',
                '1',
                'sample_sku',
                '10',
                'PROD001',
                '1'
            ]
        ];

        $callback = function () use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'sample_products.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample_products.csv"',
        ]);
    }

}
