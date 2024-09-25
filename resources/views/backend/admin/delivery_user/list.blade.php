<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Delivery User List</h6>
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
                            <th>Collected</th>
                            <th>Pending</th>
                            <th>Submitted</th>
                            <th>In. Paid</th>
                            <th>In. UnPaid</th>
                            {{-- <th>User type</th> --}}
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
                            <td>{{ $s['total_cash_collected'] }}</td>
                            <td> {{ $s['total_cash_collected'] - $s['total_cash_to_sent_back'] ?? 0 }} </td>
                            <td>{{ $s['total_cash_to_sent_back'] ?? 0 }}</td>
                            <td>{{ $s['paid_incentive'] ?? 0 }}</td>
                            <td>{{ $s['pending_incentive'] ?? 0 }}</td>
                            <td class="text-end">
                                <div class="table-action-btns">
                                    @if($s['user_type'] == 'delivery_user')
                                    <a href={{ route('delivery.order.view', $s['id']) }} class="btn btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endif
                                    <a href={{ url('/admin/delivery-user-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{ $list->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>