<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
           
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Delivery User</th>
                            <th>Requested Amount</th>
                            <th>OTP</th>
                            <th>Approved Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        {{-- @foreach ($data as $s)
                        <tr> --}}
                            {{-- <td>{{ $a++ }}</td>
                            <td>{{ $s['delivery_user_name'] }}</td>
                            <td>{{ $s['deposit_date'] }}</td> --}}
                            {{-- <td>{{ $s['totalCashCollected'] }}</td> --}}
                            {{-- <td>{{ $s['totalDepositAmount'] }}</td> --}}
                            {{-- <td>{{ $s['cash_amount'] }}</td>
                            <td>{{ $s['deposit_amount'] }}</td>
                            <td>{{ $s['cash_amount'] - $s['deposit_amount'] }}</td> --}}
                            {{-- <td class="text-end">
                                <div class="table-action-btns">
                                    <a href={{ url('/admin/users-edit/' . $s['id']) }} class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                </div>
                            </td> --}}
                        {{-- </tr>
                        @endforeach --}}

                        @foreach($data as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->delivery_user_name }}</td>
                            <td>{{ $request->cash_amount }}</td>
                            <td>{{ $request->otp }}</td>
                            <td>{{ $request->deposit_amount ?? 'N/A' }}</td>
                            <td>{{ ucfirst($request->status) }}</td>
                            <td class="">
                                <div class="table-action-btns">
                                    @if($request->deposit_status == 'pending' || $request->deposit_status == 'verified')
                                        <a href="{{ route('deposit_requests.edit', $request->id) }}" class="btn btn-primary"> <i class="bx bx-pencil"></i></a>

                                        {{-- <a href="{{ url('/admin/edit-product/' . $value['id']) }}" class="btn btn-primary">
                                            <i class="bx bx-pencil"></i> --}}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-all">
                    {{-- {{ $data->links(); }} --}}
                </div>
            </div>
        </div>
    </div>
</div>