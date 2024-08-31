<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('deposit_requests.update', $depositRequest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf    
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2">
                            <label for="delivery_user" class="form-label">Delivery User</label>
                            <input type="text" class="form-control" id="delivery_user" value="{{ $depositRequest->delivery_user_name }}" disabled>
                        </div>
                
                        <div class="col-md-6 mb-2">
                            <label for="cash_amount" class="form-label">Requested Amount</label>
                            <input type="text" class="form-control" id="cash_amount" value="{{ $depositRequest->cash_amount }}" disabled>
                        </div>
                
                        <div class="col-md-6 mb-2">
                            <label for="deposit_amount" class="form-label">Approved Amount</label>
                            <input type="number" class="form-control" name="deposit_amount" id="deposit_amount" value="{{ old('deposit_amount', $depositRequest->deposit_amount) }}" step="0.01">
                        </div>
                
                        <div class="col-md-6 mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="approved" {{ $depositRequest->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $depositRequest->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
