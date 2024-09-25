<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Sales</h6>
                    </div>
                    {{-- <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <h6>Quick Actions</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin/add-user') }}">Add Users</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Delivery person</th>
                            <th>Deposit date</th>
                            {{-- <th>Total Cash Deposit</th> --}}
                            <th>Cash Amount</th>
                            <th>Deposit Amount</th>
                            <th>Total Pending Cash</th>
                            {{-- <th class="text-end">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach ($data as $s)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $s['delivery_user_name'] }}</td>
                            <td>{{ $s['deposit_date'] }}</td>
                            {{-- <td>{{ $s['totalCashCollected'] }}</td> --}}
                            {{-- <td>{{ $s['totalDepositAmount'] }}</td> --}}
                            <td>{{ $s['cash_amount'] }}</td>
                            <td>{{ $s['deposit_amount'] }}</td>
                            <td>{{ $s['cash_amount'] - $s['deposit_amount'] }}</td>
                            {{-- <td class="text-end">
                                <div class="table-action-btns">
                                    <a href={{ url('/admin/users-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                </div>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{-- {{ $data->links(); }} --}}
                </div>
            </div>
        </div>
    </div>
</div>