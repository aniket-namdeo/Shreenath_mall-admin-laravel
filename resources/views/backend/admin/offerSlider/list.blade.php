<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')

        <div class="card member-statistics h-auto billing-table">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Offer Slider List</h6>
                    </div>
                    <div class="dropdown  filter-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-menu-alt-right'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <h6>Quick Actions</h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin/offer-slider') }}">Add Offer Slider</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="table-id">Id</th>
                            <th>Category</th>
                            <th>Banner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $a = 1; @endphp

                        @foreach($list as $offerSliderData)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $offerSliderData->category_name }}</td>
                            <td>
                                @if($offerSliderData->banner)
                                    <img src="{{ 'https://shreenathmall.smed.site/' . $offerSliderData->banner }}" alt="Offer Slider Image">
                                @else
                                    NA
                                @endif
                            </td>
                            
                            
                            <td>
                                <div class="table-action-btns">
                                    <a href="{{ url('/admin/edit-offer-slider/' . $offerSliderData['id']) }}" class="btn btn-primary">
                                        <i class="bx bx-pencil"></i>
                                    </a>
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