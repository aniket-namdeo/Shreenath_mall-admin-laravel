@empty(!$list)

@php $imgUrl = ($details->image != "" && $details->image != null) ? $details->image : "uploads/default.jpg"; @endphp


<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('update-offer-slider.update', $details->id); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label for="parentCategoryId">Select Category</label>
                            <select class="form-control" id="subCategoryId" name="subCategoryId">
                                <option value="">Select a category</option>
                                @foreach($categorylist as $offerSliderData)
                                    <option value="{{ $details->id }}">{{ $offerSliderData->name }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <div class="col-md-4 form-group mb-3">
                            <label for="image"> Banner</label>
                            <input type="file" name="banner" class="form-control" onchange="readURL(this);" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <img alt="Offer Slider Image" src="{{ asset('uploads/default.jpg');  }}" class="img-responsive rounded" width="100" height="auto" id="img_preview" />
                        </div>
                        

                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="status">status</label>
                            <select class="form-control" name="status">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
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

@endempty