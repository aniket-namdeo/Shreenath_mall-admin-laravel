<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Delivery User List</h6>
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
                            <th>Gender</th>
                            <th>Incentive</th>
                            <th class="text-end">Created At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($deliveryUser as $s)
                            <tr>
                                <td>{{ $a++ }}</td>
                                <td>{{ $s['name'] }}</td>
                                <td>{{ $s['email'] }} <br>{{ $s['contact'] }}</td>
                                <td>{{ $s['gender'] }}</td>
                                <td>{{ $s['incentive_type'] }} <br> {{ $s['incentive']; }}</td>
                                <td class="text-end">{{ date('d M, Y', strtotime($s['created_at'])); }}</td>
                                <td class="text-end">
                                    <div class="table-action-btns">
                                        @if($s['user_type'] == 'delivery_user')
                                        <a href={{ url('cashier/cashier-delivery-user/' . $s['id']); }} class="btn btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif
                                        <a href={{ url('cashier/cashier-delivery-user/' . $s['id'].'/edit') }} class="btn btn-primary">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{ $deliveryUser->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>