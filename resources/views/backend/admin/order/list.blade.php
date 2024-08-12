<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0"> Order List</h6>
                    </div>
                    {{-- <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                    </div> --}}
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Order id</th>
                            <th>User Name</th>
                            <th>Total amount</th>
                            <th>Order Status</th>
                            <th>Delivery status</th>
                            <th>Payment status</th>
                            <th>Date/Time</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($orderList as $value)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->total_amount ?? 'N/A' }}</td>
                            <td>{{ $value->status }}</td>
                            <td>{{ $value->delivery_status }}</td>
                            <td>{{ $value->payment_status }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <div class="table-action-btns">
                                    <a href="javascript:void(0);" data-order-id="{{ $value->id }}" class="btn btn-success btn-xs text-white btn-assign-order">
                                        <i class="bx bx-user-plus"></i>
                                    </a>
                                    <a href="{{ url('/admin/edit-order/' . $value['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" url={{ route('order.cancel', $value->id) }} class="btn btn-danger btn-xs text-white btn-cancel">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-all">
                    {{ $orderList->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignOrderModal" tabindex="-1" role="dialog" aria-labelledby="assignOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignOrderModalLabel">Assign Delivery User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignOrderForm" method="POST" action="{{ route('order.assign') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="order_id">

                    <div id="assign-section" class="form-group">
                        <label for="delivery_user_id">Select Delivery User</label>
                        <select name="delivery_user_id" id="delivery_user_id" class="form-control">
                            @foreach($deliveryUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="assigned-section" class="form-group mt-3" style="display: none;">
                        <label for="assigned_user">Assigned Delivery User</label>
                        <input type="text" id="assigned_user" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="assignButton" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- <script>
    $(document).ready(function() {
        $('.btn-assign-order').click(function() {
            var orderId = $(this).data('order-id');
            $('#order_id').val(orderId);
            $('#assignOrderModal').modal('show');
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        $('.btn-assign-order').click(function() {
            var orderId = $(this).data('order-id');
            $('#order_id').val(orderId);

            $.ajax({
                type: 'GET',
                url: '{{ route('order.checkAssignment') }}',
                data: { order_id: orderId },
                success: function(response) {
                    if (response.assigned) {
                        $('#assign-section').show();
                        $('#assignButton').show();
                        $('#assigned-section').show();
                        $('#assigned_user').val(response.delivery_user_name);
                    } 
                    else {
                        $('#assign-section').show();
                        $('#assignButton').show();
                        $('#assigned-section').hide();
                    }

                    $('#assignOrderModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

