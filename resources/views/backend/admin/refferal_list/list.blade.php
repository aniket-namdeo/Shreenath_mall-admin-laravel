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
                            <th>Referred Name</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($formattedReferrals as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $value['referrer_name'] }}</td> <!-- Updated to use array notation -->
                            <td>{{ $value['referred_name'] }}</td> <!-- Updated to use array notation -->
                            {{-- <td> --}}
                                {{-- <div class="table-action-btns">
                                    <a href="{{ url('/admin/edit-product/' . $value['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" url={{ route('product.destroy', $value->id) }} class="btn btn-danger btn-xs text-white btn-delete">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div> --}}
                            {{-- </td> --}}
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
