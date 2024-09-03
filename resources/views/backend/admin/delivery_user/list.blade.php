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
                            <th>Verified</th>
                            <th>Cash collected</th>
                            <th>Pending Cash</th>
                            <th>Cash submitted</th>
                            <th>Incentive Paid</th>
                            <th>Incentive UnPaid</th>
                            {{-- <th>User type</th> --}}
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach ($list as $s)

                        {{-- @php
                        $incentive = $incentives->get($s->id, (object) ['total_incentive_paid' => 0, 'total_incentive_unpaid' => 0]);
                    @endphp --}}
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $s['name'] }}</td>
                            <td>{{ $s['email'] }}</td>
                            <td>{{ $s['contact'] }}</td>
                            <td>{{ $s['status'] }}</td>
                            <td>{{ $s['total_cash_collected'] }}</td>
                            <td> {{ $s['total_cash_collected'] - $s['total_cash_to_sent_back'] ?? 0 }} </td>
                            <td>{{ $s['total_cash_to_sent_back'] ?? 0 }}</td>
                            <td>{{ $s['paid_incentive'] ?? 0 }}</td>
                            <td>{{ $s['pending_incentive'] ?? 0 }}</td>
                            {{-- <td>{{ $incentive->total_incentive_paid }}</td>
                            <td>{{ $incentive->total_incentive_unpaid }}</td> --}}
                            <td class="text-end">
                                <div class="table-action-btns">
                                    <a href={{ url('/admin/delivery-user-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href={{ url('/admin/delivery-user-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-edit"></i>
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