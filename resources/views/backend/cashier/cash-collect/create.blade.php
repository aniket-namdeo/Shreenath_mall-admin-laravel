<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ url('cashier/cash-collect'); }}" method="POST">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="delivery_user_id">Select Delivery Boy</label>
                            <select class="form-control js-example-basic-single" name="delivery_user_id" required>
                                <option value="" selected disabled> -- -- </option>
                                @foreach($delivery_user as $d)
                                    <option value="{{ $d->id; }}">{{ $d->name.' - '.$d->contact; }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Collect Amount</label>
                            <input type="text" class="form-control" name="collected_amount"
                                onkeypress="return /[0-9]/i.test(event.key)" required value="{{ old('collected_amount') }}" />
                        </div>
                        <div class="col-md-4 text-center mt-4">
                            <button type="submit" class="btn web-btn w-100">
                                Collect
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
