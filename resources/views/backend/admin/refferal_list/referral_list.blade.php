<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Referral List</h6>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Referrer Name</th>
                            <th>Referral Type</th>
                            <th>Referral Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($formattedReferrals as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>
                                @if($value['referrer_user_name'] == '')
                                    {{ $value['referrer_employee_name'] }}
                                @else
                                    {{ $value['referrer_user_name'] }}
                                @endif
                            </td>
                            <td>
                                {{ $value['referr_type'] }}
                            </td>
                            <td>
                                {{ $value['referral_count'] }}
                            </td>
                            <td>
                                <a href="{{ url('/admin/referralListById/' . $value->referrer_id. '/'. $value->referr_type) }}" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination pagination-all">
                    {{-- {{ $list->links(); }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
