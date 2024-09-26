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
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Delivery User Id</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Collected At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($orderList as $s)
                            <tr>
                                <td>{{ $a++ }}</td>
                                <td>{{ $s['name'] }}</td>
                                <td>{{ $s['contact'] }}</td>
                                <td>{{ $s['delivery_user_id'] }}</td>
                                <td>{{ "₹".$s['collected_amount'] }}</td>
                                <td>{{ $s['collected_status'] }}</td>
                                <td>{{ date('d M, Y', strtotime($s['created_at'])); }}</td>
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