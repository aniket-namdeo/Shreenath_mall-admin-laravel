<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0"> Tag List</h6>
                    </div>
                    <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <h6>Quick Actions</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin/add-tag') }}">Add Tag</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Tag Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($list as $tag)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $tag->name }}</td>
                            
                            <td>
                                <div class="table-action-btns">
                                    <a href="{{ url('/admin/productTagAssign-list/' . $tag['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i>
                                    </a>
                                    <a href="{{ url('/admin/edit-tag/' . $tag['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-all">
                    {{-- {{ $list->links(); }} --}}
                </div>
            </div>
        </div>
    </div>
</div>