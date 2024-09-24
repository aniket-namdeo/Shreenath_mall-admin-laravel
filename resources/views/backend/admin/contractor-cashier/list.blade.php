<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Users List</h6>
                    </div>
                   <a href="{{ url('admin/contractor-cashier/create'); }}" class="btn web-btn">
                        Add New
                   </a>
                </div>
            </div>
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>User Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Type</th>
                            <th>Commission</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach ($list as $s)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $s['user_type'] }}</td>
                            <td>{{ $s['name'] }}</td>
                            <td>{{ $s['email'] }}</td>
                            <td>{{ $s['contact'] }}</td>
                            <td>{{ Str::ucfirst($s['commission_type']); }}</td>
                            <td>{{ $s['commission'] }}</td>
                            <td class="text-end">
                                <div class="table-action-btns">
                                    <a href={{ url('/admin/contractor-cashier/'.$s['id'].'/edit') }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" url={{ url('/admin/contractor-cashier/delete/' . $s['id']) }} class="btn btn-danger btn-delete">
                                        <i class="bx bx-trash"></i>
                                    </a>
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