<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('add-offer-slider.store'); }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label for="category">Select Category</label>
                            <select class="form-control" id="subCategoryId" name="subCategoryId">
                                <option value="">Select a category</option>
                                @foreach($list as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="banner">Banner</label>
                            <input type="file" class="form-control" id="banner" name="banner">
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