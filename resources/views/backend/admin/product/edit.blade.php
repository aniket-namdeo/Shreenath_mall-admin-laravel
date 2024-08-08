<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('update-product.update', $details->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $details->product_name) }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $details->price) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="mrp">MRP</label>
                            <input type="number" step="0.01" class="form-control" id="mrp" name="mrp" value="{{ old('mrp', $details->mrp) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="discount_percent">Discount Percent</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percent" name="discount_percent" value="{{ old('discount_percent', $details->discount_percent) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="category_id">Select Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select a category</option>
                                @foreach($categoryList as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $details->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="brand_id">Select Brand</label>
                            <select class="form-control" id="brand_id" name="brand_id">
                                <option value="">Select a brand</option>
                                @foreach ($brandList as $brand)
                                    <option value="{{ $brand->id }}" {{ $brand->id == old('brand_id', $details->brand_id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="sku">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $details->sku) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $details->stock) }}">
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <label for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $details->brand) }}">
                        </div> --}}
                        <div class="col-md-4 mb-2">
                            <label for="product_code">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="product_code" value="{{ old('product_code', $details->product_code) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="pack_size">Pack Size</label>
                            <input type="number" class="form-control" id="pack_size" name="pack_size" value="{{ old('pack_size', $details->pack_size) }}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" id="tag" name="tag" value="{{ $details->tag }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="image_url1">Product Image1</label>
                            <input type="file" class="form-control" id="image_url1" name="image_url1">
                            @if ($details->image_url1)
                                <img src="{{ "https://shreenathmall.smed.site/".$details->image_url1 }}" alt="{{ $details->image_url1 }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="image_url2">Product Image2</label>
                            <input type="file" class="form-control" id="image_url2" name="image_url2">
                            @if ($details->image_url2)
                                <img src="{{ "https://shreenathmall.smed.site/".$details->image_url2 }}" alt="{{ $details->image_url2 }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="image_url3">Product Image3</label>
                            <input type="file" class="form-control" id="image_url3" name="image_url3">
                            @if ($details->image_url3)
                                <img src="{{ "https://shreenathmall.smed.site/".$details->image_url3 }}" alt="{{ $details->image_url3 }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="image_url4">Product Image4</label>
                            <input type="file" class="form-control" id="image_url4" name="image_url4">
                            @if ($details->image_url4)
                                <img src="{{ "https://shreenathmall.smed.site/".$details->image_url4 }}" alt="{{ $details->image_url4 }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $details->description) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
