
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
        return confirm("Are you sure you want to delete your account? This action cannot be undone.");
    }
</script>
</body>
</html>