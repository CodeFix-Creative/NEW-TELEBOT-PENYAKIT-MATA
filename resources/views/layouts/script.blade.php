<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  {{-- <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script> --}}

<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
<script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>
{{-- <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script> --}}

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>


{{-- CUSTOM --}}
<script type="text/javascript">
    $('.daterange-cus').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        drops: 'down',
        opens: 'right'
    });

    @if(Session::has('toast_success'))
    iziToast.success({
        title: 'Berhasil !',
        message: '{{ Session::get('
        toast_success ') }}',
        position: 'topRight'
    });
    @elseif(Session::has('toast_error'))
    iziToast.error({
        title: 'Gagal !',
        message: '{{ Session::get('
        toast_error ') }}',
        position: 'topRight'
    });
    @endif

</script>

<script>
    $("#modal-filter").fireModal({
        title: 'Filter Data',
        body: $("#modal-filter-part"),
        footerClass: 'bg-whitesmoke',
        autoFocus: false,
        shown: function (modal, form) {
            console.log(form)
        },
        buttons: [{
            text: 'Filter',
            submit: true,
            class: 'btn btn-primary btn-shadow',
            method: 'POST',
            handler: function (modal) {}
        }]
    });

</script>

@stack('script')
