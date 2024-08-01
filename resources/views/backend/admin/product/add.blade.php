<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('add-product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ old('product_name') }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="price">Selling Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                value="{{ old('price') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="mrp">MRP</label>
                            <input type="number" step="0.01" class="form-control" id="mrp" name="mrp"
                                value="{{ old('mrp') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="discount_percent">Discount Percent</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percent"
                                name="discount_percent" value="{{ old('discount_percent') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="category_id">Select Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select a category</option>
                                @foreach ($categoryList as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="sku">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku"
                                value="{{ old('sku') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock"
                                value="{{ old('stock') }}">
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <label for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}">
                        </div> --}}
                        <div class="col-md-4 mb-2">
                            <label for="product_code">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                value="{{ old('product_code') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="pack_size">Pack Size</label>
                            <input type="number" class="form-control" id="pack_size" name="pack_size"
                                value="{{ old('pack_size') }}">
                        </div>
                        <div class="col-md-4 mb-3 col-8">
                            <label for="image_url1">Product Image1</label>
                            <input type="file" class="form-control" id="image_url1" onchange="readURL(this, '1');"
                                accept="image/webp" name="image_url1">
                        </div>

                        <div class="col-md-2 col-4">
                            <img alt="product image" src="{{ asset('uploads/default.jpg') }}"
                                class="w-100 img-responsive mt-2 rounded" width="100" height="auto"
                                id="img_preview1" />
                        </div>
                        <div class="col-md-4 mb-2 col-8">
                            <label for="image_url2">Product Image2</label>
                            <input type="file" class="form-control" id="image_url2" onchange="readURL(this, '2');"
                                accept="image/webp" name="image_url2">
                        </div>
                        <div class="col-md-2 col-4">
                            <img alt="product image" src="{{ asset('uploads/default.jpg') }}"
                                class="w-100 img-responsive mt-2 rounded" width="100" height="auto"
                                id="img_preview2" />
                        </div>
                        <div class="col-md-4 mb-2 col-8">
                            <label for="image_url3">Product Image3</label>
                            <input type="file" class="form-control" id="image_url3"
                                onchange="readURL(this, '3');" accept="image/webp" name="image_url3">
                        </div>
                        <div class="col-md-2 col-4">
                            <img alt="product image" src="{{ asset('uploads/default.jpg') }}"
                                class="w-100 img-responsive mt-2 rounded" width="100" height="auto"
                                id="img_preview3" />
                        </div>
                        <div class="col-md-4 mb-2 col-8">
                            <label for="image_url4">Product Image4</label>
                            <input type="file" class="form-control" id="image_url4"
                                onchange="readURL(this, '4');" accept="image/webp" name="image_url4">
                        </div>
                        <div class="col-md-2 col-4">
                            <img alt="product image" src="{{ asset('uploads/default.jpg') }}"
                                class="w-100 img-responsive mt-2 rounded" width="100" height="auto"
                                id="img_preview4" />
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
