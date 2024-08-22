<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('productTagAssign.store'); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">

                        <input type="hidden" name="tag_id" value="{{ $id }}">

                        <div class="col-md-4 mb-2">
                            <label for="product">Select product</label>
                            <select class="form-control js-example-basic-single" multiple id="product" name="product[]">
                                <option value="">Select a product</option>
                                @foreach($productData as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
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