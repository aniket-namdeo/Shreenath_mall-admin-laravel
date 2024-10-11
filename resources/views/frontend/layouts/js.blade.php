
<script src="{{ asset('includes-frontend/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>  
<script src="{{ asset('includes-frontend/parallax/jarallax.js'); }}"></script>  
<script src="{{ asset('includes-frontend/smoothscroll/smooth-scroll.js'); }}"></script>  
<script src="{{ asset('includes-frontend/ytplayer/index.js'); }}"></script>  
<script src="{{ asset('includes-frontend/scrollgallery/scroll-gallery.js'); }}"></script>  
<script src="{{ asset('includes-frontend/theme/js/script.js'); }}"></script> 

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

<!-- Include SweetAlert JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


@if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

          
    <script>
    function confirmDelete() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form to delete the account
                document.getElementById('delete-account-form').submit();
            }
        });
    }
</script>

</body>
</html>