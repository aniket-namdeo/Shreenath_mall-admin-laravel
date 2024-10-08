<script src="{{ asset('includes-backend/js/select2.min.js') }}"></script>

<script src="{{ asset('includes-backend/js/unitegallery.min.js') }}"></script>

<script src="{{ asset('includes-backend/js/ug-theme-tilesgrid.js') }}"></script>

<script src="{{ asset('includes-backend/js/owl.carousel.js') }}"></script>

<script src="{{ asset('includes-backend/js/apexcharts.min.js') }}"></script>

<script src="{{ asset('includes-backend/js/second-medic.js') }}"></script>
<script language="JavaScript" src="{{ asset('includes-backend/js/jquery.dataTables.min.js'); }}" type="text/javascript"></script>
<script language="JavaScript" src="{{ asset('includes-backend/js/dataTables.bootstrap.min.js'); }}" type="text/javascript"></script>
<script language="JavaScript" src="{{ asset('includes-backend/js/dataTables.responsive.min.js'); }}" type="text/javascript"></script>

<script language="JavaScript" src="{{ asset('includes-backend/js/responsive.bootstrap.min.js'); }}" type="text/javascript"></script>

<script src="{{ asset('includes-backend/js/editor.js') }}"></script>

<script>
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
 
     const getEditorData = () => {
         return {
             selector: 'textarea#description',
             plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
             editimage_cors_hosts: ['picsum.photos'],
             menubar: 'file edit view insert format tools table',
             toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
             autosave_ask_before_unload: true,
             autosave_interval: '30s',
             autosave_prefix: '{path}{query}-{id}-',
             autosave_restore_when_empty: false,
             autosave_retention: '2m',
             image_advtab: true,
             importcss_append: true,
             height: 300,
             image_caption: true,
             quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
             noneditable_class: 'mceNonEditable',
             toolbar_mode: 'sliding',
             contextmenu: 'link image table',
             skin: useDarkMode ? 'oxide-dark' : 'oxide',
             content_css: useDarkMode ? 'dark' : 'default',
             content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
             referrer_policy: 'strict-origin-when-cross-origin'
         };
     };
  </script>

<script>
    $(document).ready(function() {
        $("#tableDrop").DataTable({
            pageLength: 20,
            buttons: ["copy", "csv", "excel", "pdf", "print"],
        });
    });
</script>

@if (@$current_page == 'users')
<script>
    CKEDITOR.replace("user_details");

    $('#country').change(function() {
        var country_id = $(this).val();
        $.ajax({
            url: "{{ url('state') }}/" + country_id,
            method: "GET",
            success: function(result) {
                data = "";
                result.forEach(function(result, index) {
                    data += "<option value='" + result.state_id + "'>" + result.name +
                        "</option>";
                });
                $('#state').html(data);
            },
        });
    });

    $('#state').change(function() {
        var state_id = $(this).val();
        $.ajax({
            url: "{{ url('city') }}/" + state_id,
            method: "GET",
            success: function(result) {
                data = "";
                result.forEach(function(result, index) {
                    data += "<option value='" + result.city_id + "'>" + result.name +
                        "</option>";
                });
                $('#city').html(data);
            }
        });
    });
</script>
@endif

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('.btn-delete').click(function() {
        swal({
            title: "Are you sure?",
            text: "Are you sure to delete this data",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var url = $(this).attr('url');
                window.location.href = url;
                return true;
            } else {
                return false;
            }
        });
    });
</script>

<script>
    $('.btn-cancel').click(function() {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to cancel this order",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var url = $(this).attr('url');
                window.location.href = url;
                return true;
            } else {
                return false;
            }
        });
    });
</script>

@if(@$current_page == "add-product" || @$current_page == "product" )

<script>
    function readURL(input, params) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img_preview' + params).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endif

@if(@$current_page == "add-product" || @$current_page == "product")
<script>
    tinymce.init(getEditorData());
</script>
@endif

@if(@$current_page == "customer-review")
<script>
    $('.review').click(function() {

        var name = $(this).attr('name');
        var rating = $(this).attr('rating');
        var contact = $(this).attr('contact');
        var review_status = $(this).attr('review_status');
        var message = $(this).attr('message');

        $('#reviewModel #name').text(name);
        $('#reviewModel #contact').text(contact);
        $('#reviewModel #rating').text(rating);
        $('#reviewModel #review_status').text(review_status.toUpperCase());
        $('#reviewModel #message').text(message);
    });
</script>

<script>
    $('.review_status_change').change(function() {

        var attr_name = $(this).attr('name');

        var attr_value = $(this).val();

        var id = $(this).attr('id');

        var url = "{{ url('admin/review-status-update'); }}/" + id;

        $.ajax({
            url: url,
            method: "POST",
            data: {
                attr_name: attr_name,
                attr_value: attr_value,
                _token: "{{ csrf_token() }}"
            },
            success: function(result) {},
        });
    });
</script>
@endif

@if(@$current_page == "seo-data" || @$current_page == "add-health-plan" || @$current_page == "healthplan")
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img_preview').attr('src', e.target.result);
            };
            reader.onload = function(e) {
                $('#img_preview1').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endif

@if(@$current_page == "add-health-plan" || @$current_page == "healthplan")
<script>
    CKEDITOR.replace("");
    
</script>
@endif

@if(@$current_page == "add-health-plan" || @$current_page == "healthplan")
    <script>
        document.getElementById('add').addEventListener('click', function() {
        let fieldGroup = document.createElement('li'); 
        fieldGroup.className = 'field-group';
        fieldGroup.innerHTML = `
            <button type="button" class="btn btn-danger remove">Remove</button>
            <div class="row align-items-center">
            <div class="col-md-4 mb-2">
                            <label class="form-label" for="">Plan Detail Heading</label>
                            <input type="text" class="form-control" name="plan_detail_heading[]" onkeypress="return /[A-Za-z ]/i.test(event.key)" required  />
                        </div>
            <div class="col-md-4 form-group mb-1">
                            <label for="plan_detail_image">Plan Detail Image</label>
                            <input type="file" name="detail_image_url[]" class="form-control" onchange="readURL(this);" required />
                        </div>
                        <div class="col-md-2 mb-2">
                            <img alt="Plan Detail Image" src="{{ asset('uploads/default.jpg');  }}" class="img-responsive rounded" width="100" height="auto" id="img_preview" />
                        </div>

                        <div class="col-md-full mb-2">
                            <label class="form-label" for="">Plan Bullet Points</label>
                            <textarea class="form-control" name="plan_bullet_points[]" required ></textarea>
                        </div>
                        </div>
        `;
        document.querySelector('.dynamic_field').appendChild(fieldGroup); 

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove')) {
                e.target.closest('.field-group').remove();
            }
        });
        });
    </script>
@endif

<script>
    function readURL(input, showData) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img_preview_' + showData).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>

    function updatePickedupStatus(orderId){

        swal({
            title: "Are you sure?",
            text: `Are you sure to picked up order Id - SNM${orderId}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `{{ url('cashier/order-pickedup/'); }}`,
                    method: "POST",
                    data: {
                        order_id: orderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(result) {
                        $(`#order-${orderId}`).css('background','#DC143C');
                        $(`#order-${orderId}`).css('color','white');
                    },
                    error:function(error){
                        swal({
                            title: "Error",
                            text: `Order Not Assigned Yet - SNM${orderId}`,
                            icon: "error",
                        });
                    }
                });
                return true;
            } else {
                return false;
            }
        });

    }

</script>



@if(@$current_page == "contact-request")
    <script>
        $('.contact-request').click(function(){

            var name = $(this).attr('name');
            var email = $(this).attr('email');
            var contact = $(this).attr('contact');
            var subject = $(this).attr('subject');
            var message = $(this).attr('message');

            $('#viewDetailsModal #name').text(name);
            $('#viewDetailsModal #email').text(email);
            $('#viewDetailsModal #contact').text(contact);
            $('#viewDetailsModal #subject').text(subject);
            $('#viewDetailsModal #message').text(message);
        });
    </script>
@endif

<script>
    tinymce.init(getEditorData());
</script>

</body>
</html>