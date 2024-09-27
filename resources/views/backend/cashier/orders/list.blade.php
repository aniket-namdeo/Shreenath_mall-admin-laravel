<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Orders List</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Order Id</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>Order At</th>
                            <th>Pickup OTP</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($orderList as $s)
                            <tr id="order-{{ $s['id']; }}">
                                <td>{{ $a++ }}</td>
                                <td>{{ "SNM".$s['id'] }}</td>
                                <td>{{ "₹".$s['total_amount'] }}</td>
                                <td>{{ $s['payment_status'] }}</td>
                                <td>{{ $s['payment_method'] }}</td>
                                <td>{{ date('d M, Y', strtotime($s['order_date'])); }}</td>
                                <td>{{ $s['pickup_otp'] }}</td>
                                <td class="text-end">
                                    <div class="table-action-btns">
                                        <a class="btn btn-info btn-pickedup" href="{{ url('cashier/order-details/'.$s['id']); }}" >
                                           view
                                        </a>
                                        <a class="btn btn-primary btn-pickedup" onclick="updatePickedupStatus({{ $s['id']; }})">
                                           Picked Up
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{ $orderList->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>