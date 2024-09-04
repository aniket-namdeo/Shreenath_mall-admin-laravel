<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">


                <form action="{{ route('incentive.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="row align-items-center">
                                
                                <div class="col-md-4 mb-2">
                                    <label for="delivery_user_id">Select User</label>
                                    <select class="form-control" id="delivery_user_id" name="delivery_user_id">
                                        <option value="">Select User</option>
                                        @foreach ($deliveryUser as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-2">
                                    <label for="total_amount">Total amount</label>
                                    <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount"
                                        value="{{ old('total_amount') }}">
                                </div>
                               
                                <div class="col-md-12">
                                    <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>User</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Pending Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp
                        
                        @foreach($list as $data)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $data->delivery_user_name }}</td>
                            <td>{{ $data->total_amount }}</td>
                            <td>{{ $data->paid_amount }}</td>
                            <td>{{ $data->pending_amount }}</td>                      
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