<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0"> Order List</h6>
                    </div>
                    {{-- <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                    </div> --}}
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Order id</th>
                            <th>User Name</th>
                            <th>Total amount</th>
                            <th>Order Status</th>
                            <th>Delivery status</th>
                            <th>Payment status</th>
                            <th>Date/Time</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($orderList as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->total_amount ?? 'N/A' }}</td>
                            <td>{{ $value->status }}</td>
                            <td>{{ $value->delivery_status }}</td>
                            <td>{{ $value->payment_status }}</td>
                            <td>{{ $value->order_date }}</td>
                            <td>
                                <div class="table-action-btns">
                                    <a href="{{ url('/admin/edit-order/' . $value['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" url={{ route('order.cancel', $value->id) }} class="btn btn-danger btn-xs text-white btn-cancel">
                                        <i class="bx bx-trash"></i>
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