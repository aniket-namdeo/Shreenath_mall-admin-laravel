
<footer>
            <div class="footer">
                <p>2022 &copy; SecondMedic Admin</p>
                <p>Designed by SecondMedic</p>
            </div>
        </footer>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <span>Are you sure?</span><br />
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body web-overflow">
                <p class="text-center my-4">Do you really want to delete these records? This process cannot be undone</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="javascript:;" data-bs-dismiss="modal" class="btn btn-default">Cancel</a>
                <a href="javascript:;" class="btn web-btn bg-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tableEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <span>Edit</span><br />
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body web-overflow">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Email Address</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Mobile No.</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Company</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Order</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Address</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Authors</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Company</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Progress</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center justify-content-center ">
                <a href="javascript:;" class="btn btn-default" data-bs-dismiss="modal">Discard</a>
                <a href="javascript:;" class="btn web-btn">Submit</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <span>Add New Card</span><br />
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body web-overflow">
                <div class="mb-3">
                    <label class="form-label" for="">Name On Card</label>
                    <input type="email" class="form-control" placeholder="Ana Simmons">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="">Card Number</label>
                    <input type="email" class="form-control" placeholder="1111 1111 1111 1111">
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">Expiration Date</label>
                            <select name="" id="" class="form-control">
                                <option value="">Month</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                                <option value="">5</option>
                                <option value="">6</option>
                                <option value="">7</option>
                                <option value="">8</option>
                                <option value="">9</option>
                                <option value="">10</option>
                                <option value="">11</option>
                                <option value="">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="">&nbsp;</label>
                            <select name="" id="" class="form-control">
                                <option value="">Year</option>
                                <option value="">2022</option>
                                <option value="">2023</option>
                                <option value="">2024</option>
                                <option value="">2025</option>
                                <option value="">2026</option>
                                <option value="">2027</option>
                                <option value="">2028</option>
                                <option value="">2029</option>
                                <option value="">2030</option>
                                <option value="">2031</option>
                                <option value="">2032</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label" for="">CVV</label>
                        <input type="text" class="form-control" placeholder="CVV">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <label class="form-label m-0">Save card for further billing?</label>
                        <p class="m-0 switch-p-tag">If you need more info, please check budget planning</p>
                    </div>
                    <div class="form-check form-switch form-switch-md">
                        <input type="checkbox" class="form-check-input" id="customSwitchsizemd">
                        <label class="form-check-label" for="customSwitchsizemd"></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center justify-content-center ">
                <a href="javascript:;" class="btn btn-default">Discard</a>
                <a href="javascript:;" class="btn web-btn">Submit</a>
            </div>
        </div>
    </div>
</div>

        <!-- Modal 2 -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <span>Add New Card</span><br />
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body web-overflow">
                <div class="bill-warning d-flex align-items-center mb-3">
                    <div class="sign-div">
                        <i class="fa fa-exclamation"></i>
                    </div>
                    <div class="content">
                        <h6 class="m-0">We Need Your Attention!</h6>
                        <p class="m-0">Your payment was declined. To start using tools, please <a href="pricing.html" class="web-clr">Add Payment Method</a>.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="" class="form-label">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <select class="js-example-basic-single" name="state">
                        <option value="">Select...</option>
                        <option value="">India</option>
                        <option value="">Africa</option>
                        <option value="">Japan</option>
                        <option value="">US</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Address Line 1</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Address Line 2</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Town</label>
                    <input type="text" class="form-control">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="" class="form-label">State / Province</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Post Code</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <label class="m-0 form-label">Save card for further billing?</label>
                        <p class="m-0 switch-p-tag">If you need more info, please check budget planning</p>
                    </div>
                    <div class="form-check form-switch form-switch-md">
                        <input type="checkbox" class="form-check-input" id="customSwitchsizemd">
                        <label class="form-check-label" for="customSwitchsizemd"></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="javascript:;" class="btn btn-default">Discard</a>
                <a href="javascript:;" class="btn web-btn">Submit</a>
            </div>
        </div>
    </div>
</div>
