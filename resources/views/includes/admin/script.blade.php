<!-- Bootstrap core JavaScript-->
<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ url('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ url('backend/vendor/select2/js/select2.full.min.js') }}"></script>

<!-- Sweet Alert 2 -->
<script src="{{ url('backend/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ url('backend') }}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('backend') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ url('backend/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ url('backend/vendor/chart.js/Chart.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>