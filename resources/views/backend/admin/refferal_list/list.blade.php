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
                            <th>Referred Name</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1; @endphp
                        @foreach($formattedReferrals as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>
                                @if($value['referrer_name_delivery'] == '')
                                    {{ $value['referred_name'] }}
                                @else
                                    {{ $value['referrer_name_delivery'] }}
                                @endif
                            </td>
                            
                            <td>{{ $value['referr_type'] }}</td>
                            {{-- <td>{{ $value['referrer_name_user']  referred_name }}</td> --}}

                            <td>
                                @if($value['referrer_name_user'] == '')
                                    {{ $value['referred_name'] }}
                                @else
                                    {{ $value['referrer_name_user'] }}
                                @endif
                            </td>
                            <td>{{ $value['referral_status'] }}</td>
                            <td>20</td>
                            <td>
                                <div class="table-action-btns">
                                    <button class="btn btn-primary" 
                                        data-toggle="modal" 
                                        data-target="#editModal" 
                                        data-id="{{ $value['referral_id'] }}"
                                        data-status="{{ $value['referral_status'] }}">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                </div>
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Referral Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('updateReferralStatus.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="referral_id" id="referral_id">
                    <div class="form-group">
                        <label for="referral_status">Referral Status</label>
                        <select name="referral_status" id="referral_status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="redeemed">Redeemed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var referralId = button.data('id');
            var referralStatus = button.data('status');
            
            console.log('Referral ID:', referralId);
            console.log('Referral Status:', referralStatus);
            
            var modal = $(this);
            modal.find('#referral_id').val(referralId);
            modal.find('#referral_status').val(referralStatus);
        });
    });
</script>

