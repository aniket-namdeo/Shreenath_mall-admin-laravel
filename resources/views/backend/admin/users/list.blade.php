<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Users List</h6>
                    </div>
                    <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <h6>Quick Actions</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin/add-user') }}">Add Users</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>User type</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach ($list as $s)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $s['name'] }}</td>
                            <td>{{ $s['email'] }}</td>
                            <td>{{ $s['contact'] }}</td>
                            <td>{{ $s['user_type'] }}</td>
                            <td class="text-end">
                                <div class="table-action-btns">
                                    <a href={{ url('/admin/users-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    {{-- <a href="javascript:void(0);" url={{ url('/admin/users-delete/' . $s['id']) }} class="btn btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-all">
                    {{ $list->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>