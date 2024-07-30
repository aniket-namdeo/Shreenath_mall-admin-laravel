<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('products.bulk-upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h6 for="file" class="mb-0">Upload CSV File</h6>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <a href="{{ route('products.sample-file') }}" class="btn btn-secondary">Download Sample File</a>
    </div>
</div>