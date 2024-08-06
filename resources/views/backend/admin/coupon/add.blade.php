<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <!-- <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data"> -->
        <form action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" class="form-control" name="title" required value="{{ old('title') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="code">Code</label>
                            <input type="text" class="form-control" name="code" required value="{{ old('code') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="offtype">Offer Type</label>
                            <select class="form-control" name="offtype" required>
                                <option value="percent" {{ old('offtype') == 'percent' ? 'selected' : '' }}>Percent</option>
                                <option value="flat" {{ old('offtype') == 'flat' ? 'selected' : '' }}>Flat</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="min_purc_amount">Minimum Purchase Amount</label>
                            <input type="number" class="form-control" name="min_purc_amount" step="0.01" required value="{{ old('min_purc_amount') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="max_off_amount">Maximum Discount Amount</label>
                            <input type="number" class="form-control" name="max_off_amount" step="0.01" required value="{{ old('max_off_amount') }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control" name="expiry_date" required value="{{ old('expiry_date') }}" />
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
