<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('update-coupon.update', $details->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" class="form-control" name="title" required value="{{ old('title', $details->title) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="code">Code</label>
                            <input type="text" class="form-control" name="code" required value="{{ old('code', $details->code) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="offtype">Offer Type</label>
                            <select class="form-control" name="offtype" required>
                                <option value="percent" {{ old('offtype', $details->offtype) == 'percent' ? 'selected' : '' }}>Percent</option>
                                <option value="flat" {{ old('offtype', $details->offtype) == 'flat' ? 'selected' : '' }}>Flat</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="min_purc_amount">Minimum Purchase Amount</label>
                            <input type="number" class="form-control" name="min_purc_amount" step="0.01" required value="{{ old('min_purc_amount', $details->min_purc_amount) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="max_off_amount">Maximum Discount Amount</label>
                            <input type="number" class="form-control" name="max_off_amount" step="0.01" required value="{{ old('max_off_amount', $details->max_off_amount) }}" />
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="active" {{ old('status', $details->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $details->status) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <label for="image"> Image</label>
                            <input type="file" name="image" class="form-control" onchange="readURL(this);" />
                        </div>
                        <div class="col-md-8 mb-3">
                            <img alt="image" src="{{ asset('uploads/default.jpg');  }}" class="img-responsive rounded" width="100" height="auto" id="img_preview" />
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <label class="form-label" for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control" name="expiry_date" required value="{{ old('expiry_date', $details->expiry_date->format('Y-m-d')) }}" />
                        </div> --}}
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update Discount
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
