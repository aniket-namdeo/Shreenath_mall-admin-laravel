<div class="row">
    <div class="col-lg-12">
        @include('backend.layouts.alert')

        <form action="{{ route('update-order.update', $details->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card h-auto">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label for="total_amount">Total Amount</label>
                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" required readonly >
                        </div>
                        <div class="col-md-4">
                            <label for="status">Order Status</label>
                            {{-- <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $order->status) }}" required > --}}
                            <select class="form-control" id="status" name="status" required>
                                <option value="" disabled>Select Status</option>
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="delivery_status">Delivery Status</label>
                            {{-- <input type="text" class="form-control" id="delivery_status" name="delivery_status" value="{{ old('delivery_status', $order->delivery_status) }}" required > --}}
                            <select class="form-control" id="delivery_status" name="delivery_status" required>
                                <option value="" disabled>Select Delivery Status</option>
                                <option value="pending" {{ old('delivery_status', $order->delivery_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ old('delivery_status', $order->delivery_status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ old('delivery_status', $order->delivery_status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="returned" {{ old('delivery_status', $order->delivery_status) == 'returned' ? 'selected' : '' }}>Returned</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="payment_method">Payment Method</label>
                            {{-- <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}" required > --}}
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="" disabled>Select Payment Method</option>
                                <option value="credit_card" {{ old('payment_method', $order->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="debit_card" {{ old('payment_method', $order->payment_method) == 'debit_card' ? 'selected' : '' }}>Debit card</option>
                                <option value="net_banking" {{ old('payment_method', $order->payment_method) == 'net_banking' ? 'selected' : '' }}>Net banking</option>
                                <option value="wallet" {{ old('payment_method', $order->payment_method) == 'wallet' ? 'selected' : '' }}>Wallet</option>
                                <option value="cash_on_delivery" {{ old('payment_method', $order->payment_method) == 'cash_on_delivery' ? 'selected' : '' }}>Cash on delivery</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="payment_status">Payment Status</label>
                            {{-- <input type="text" class="form-control" id="payment_status" name="payment_status" value="{{ old('payment_status', $order->payment_status) }}" required > --}}

                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="" disabled>Select Payment Method</option>
                                <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="order_date">Order Date</label>
                            <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', $order->order_date) }}"  readonly >
                        </div>
                        <div class="col-md-4">
                            <label for="delivery_date">Delivery Date</label>
                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $order->delivery_date) }}"  >
                        </div>
                        <div class="col-md-4">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $order->coupon_code) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amount">Discount Amount</label>
                            <input type="text" class="form-control" id="discount_amount" name="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tax_amount">Tax Amount</label>
                            <input type="text" class="form-control" id="tax_amount" name="tax_amount" value="{{ old('tax_amount', $order->tax_amount) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_fee">Shipping Fee</label>
                            <input type="text" class="form-control" id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $order->shipping_fee) }}">
                        </div>
                    </fieldset>
                    
                        <legend>Order Address Details</legend>
                        
                        <div class="col-md-4">
                            <label for="house_address">House Address</label>
                            <input type="text" class="form-control" id="house_address" name="house_address" value="{{ old('house_address', $order->house_address) }}" required readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="street_address">Street Address</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" value="{{ old('street_address', $order->street_address) }}" required readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="landmark">Landmark</label>
                            <input type="text" class="form-control" id="landmark" name="landmark" value="{{ old('landmark', $order->landmark) }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $order->city) }}" required readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $order->state) }}" required readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $order->country) }}" required readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="pincode">Pincode</label>
                            <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $order->pincode) }}" required readonly>
                        </div>

                        <legend>Order Items</legend>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Product Name</th>
                                    {{-- <th>Product SKU</th> --}}
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Product Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $a = 1; @endphp

                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td>{{ $a++ }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        {{-- <td>{{ $item->product_sku }}</td> --}}
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->isCancelled == 0 ? "Active" : "Cancelled" }}</td>
                                        <td>
                                            <div class="table-action-btns">
                                                {{-- <a href="javascript:void(0);" url={{ route('order-item.cancel', $item->id) }} class="btn btn-danger btn-xs text-white">
                                                    Cancel
                                                </a> --}}

                                                <a href="javascript:void(0);" url={{ route('order-item.cancel', $item->id) }} class="btn btn-danger btn-xs text-white btn-cancel">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                            </tbody>
                        </table>
                      
                        <div class="col-md-12">
                            <button type="submit" class="btn web-btn mt-3" id="submit_btn">
                                Update
                            </button>
                        </div>
                </div>
            </div>
        </form>
    </div>
</div>
