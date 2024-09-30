<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">Orde Commission</h6>
            </div>
            <div class="card-body">
                <table class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Order Id</th>
                            <th>Total Amount</th>
                            <th>Commission</th>
                            <th class="text-end">Order At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($list as $s)
                        @php
                            $commission = 0;

                            if($s['commission_type'] == 'percentage'){
                                $commission = ($s['total_amount'] * $s['commission'])/100;
                            }else if($s['commission_type'] == 'fixed'){
                                $commission = $s['commission'];
                            }
                        @endphp
                            <tr>
                                <td>{{ $a++ }}</td>
                                <td>SNM{{ $s['id'] }}</td>
                                <td>₹{{ $s['total_amount'] }}</td>
                                <td>₹{{ $commission; }}</td>
                                <td class="text-end">{{ date('d M, Y', strtotime($s['created_at'])); }}</td>
                                <td class="text-end">
                                    <div class="table-action-btns">
                                        <a class="btn btn-info btn-pickedup" href="{{ url('cashier/order-details/'.$s['id']); }}" >
                                           view
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