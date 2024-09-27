<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        {{-- Bulk upload products --}}
        {{-- <form action="{{ route('products.bulk-upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h6 for="file" class="mb-0">Upload CSV File</h6>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        
        <a href="{{ route('products.sample-file') }}" class="btn btn-secondary">Download Sample File</a> --}}

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0"> Product List</h6>
                    </div>
                    <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <h6>Quick Actions</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin/add-product') }}">Add Product</a></li>
                            {{-- <li><a class="dropdown-item" href="{{ url('/admin/bulk-upload-product') }}">Bulk Upload Product</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Product image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($list as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $value->product_name }}</td>
                            <td>{{ $value->price ?? 'N/A' }}</td>
                            <td>{{ $value->mrp }}</td>
                            <td><img src={{ asset($value->image_url1); }}> </img></td>
                            <td>
                                <div class="table-action-btns">
                                    <a href="{{ url('/admin/edit-product/' . $value['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" url={{ route('product.destroy', $value->id) }} class="btn btn-danger btn-xs text-white btn-delete">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{-- {{ $list->links(); }} --}}
                </div>
            </div>
        </div>
    </div>
</div>