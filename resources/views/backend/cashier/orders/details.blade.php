@empty(!$order_details)

    @foreach($order_details as $o)

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        Order details
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Order Id</td>
                                <th><b>SNM{{ $o['id']; }}</b></th>
                                <td>Payment Status</td>
                                <th>{{ Str::ucfirst($o['payment_status']); }}</th>
                            </tr>
                            <tr>
                                <td>User Name</td>
                                <th>{{ $o['name']; }}</th>
                                <td>User Contact</td>
                                <th>{{ $o['contact']; }}</th>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <th>₹{{ $o['total_amount']; }}</th>
                                <td>Pickup OTP</td>
                                <th>{{ $o['pickup_otp']; }}</th>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <th>{{ $o['payment_method']; }}</th>
                                <td>Delivery Status</td>
                                <th>{{ $o['delivery_status']; }}</th>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <th colspan="3">{{ $o['house_address']." ".$o['street_address']." ".$o['landmark'].", ".$o['city']." ".$o['state']." India, Pincode: ".$o['pincode']; }}</th>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center"><b>Order Items</b></td>
                            </tr>
                            <tr>
                                <th>Sr.</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            @php $count = 1; @endphp
                            @foreach($order_items as $i)
                                <tr>
                                    <td>{{ $count++; }}</td>
                                    <td>
                                        <img src="{{ asset($i['product_image']); }}" alt="Product Image" width="100"><br>
                                        {{ $i['product_name']; }}<br>
                                        <small>Price: ₹{{ $i['price']; }}</small><br>
                                        <small>SKU: {{ $i['product_sku']; }}</small><br>
                                        <small>Product Code: {{ $i['product_code']; }}</small>    
                                    </td>
                                    <td>{{ $i['quantity']; }}</td>
                                    <td>₹{{ $i['quantity']*$i['price'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@endempty