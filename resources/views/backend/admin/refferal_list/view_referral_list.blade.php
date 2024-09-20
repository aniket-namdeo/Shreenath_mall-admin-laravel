<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Referral List</h6>

                        <br>
                        <h6 class="mb-0">Pending Count - {{ $pendingCount * 20 }}</h6>
                        
                        <br>
                        <h6 class="mb-0">Redeemed Count - {{ $redeemedCount * 20 }}</h6>
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
                        @foreach($referrals as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>
                                    {{ $value['referred_by_name'] }}
                            </td>
                            
                            <td>{{ $value['referr_type'] }}</td>

                            <td>
                                    {{ $value['user_name'] }}
                            </td>
                            <td>{{ $value['status'] }}</td>
                            <td>20</td>
                            <td>
                                <div class="table-action-btns">

                                    <button class="btn btn-primary open-edit-modal" 
                                        data-id="{{ $value['id'] }}"
                                        data-status="{{ $value['referral_status'] }}">
                                        <i class="bx bx-pencil"></i>
                                    </button>

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
                    <input type="hidden" name="id" id="id">
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
    $('.open-edit-modal').on('click', function() {
        var referralId = $(this).data('id');
        var referralStatus = $(this).data('status');
        
        console.log('Referral ID:', referralId);
        console.log('Referral Status:', referralStatus);

        $('#editModal').find('#id').val(referralId);
        $('#editModal').find('#referral_status').val(referralStatus);
        
        $('#editModal').modal('show');
    });
});

</script>


