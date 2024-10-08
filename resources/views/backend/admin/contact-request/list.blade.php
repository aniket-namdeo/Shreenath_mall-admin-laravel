<div class="row">
    <div class="col-sm-12">
        @include('backend.layouts.alert')
        
        <div class="card member-statistics h-auto billing-table">
            <div class="card-body">
                <div class="table-responsive web-overflow mt-4">
                    <table id="tableDrop" class="table dt-responsive nowrap" cellspacing="0" width="100%" style="text-align:end !important;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Enquiry At</th>
                                <th>Contact Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $a = 1; @endphp
                            @foreach($request_list as $s)
                                <tr>
                                    <td>{{ $a++; }}</td>
                                    <td>{{ $s['name']; }}</td>
                                    <td>{{ $s['email'] ; }}</td>
                                    <td>{{ $s['contact']; }}</td>
                                    <td>{{ date('d M, Y H:i:s', strtotime($s['created_at'])); }}</td>
                                    <td>
                                      {{$s['contact_status']}}  
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);" class="btn btn-info btn-xs text-white contact-request"
                                        name="{{ $s->name; }}"
                                        email="{{ $s->email; }}"
                                        contact="{{ $s->contact; }}"
                                        subject="{{ $s->subject; }}"
                                        message="{{ $s->message; }}"
                                        data-bs-toggle="modal" data-bs-target="#viewDetailsModal">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="javascript:void(0);" url={{ url('admin/contact-request-delete/'.$s['id']) }} class="btn btn-danger btn-xs text-white btn-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination pagination-all">
                    {{ $request_list->links(); }}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade myaccount-lab-modal" id="viewDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h1 class="modal-title fs-5" id="package_name"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <p>Name <br><b id="name"></b></p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p>Mobile <br><b id="contact"></b></p>
                    </div>
                    <div class="col-md-12 col-12">
                        <p>Email <br><b id="email"></b></p>
                    </div>
                    <div class="col-md-12 ">
                        <p>Subject <br><b id="subject"></b></p>
                    </div>
                    <div class="col-md-12 ">
                        <p>Message <br><b id="message"></b></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>