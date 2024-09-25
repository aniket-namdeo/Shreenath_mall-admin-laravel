<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Delivery Orders List</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Order Id</th>
                            <th>Status</th>
                            <th>Assigned At</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach ($list as $s)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ 'SNM'.$s['order_id'] }}</td>
                            <td>{{ $s['order_status'] }}</td>
                            <td>{{ date('d M, Y', strtotime($s['assigned_at'])); }}</td>
                            <td>{{ $s['payment_status'] }}</td>
                            <td>{{ $s['delivery_status'] }}</td>
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