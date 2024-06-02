<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
@if (session('info'))
    <script>
        Toast.fire({
            icon: "info",
            title: "{{ session('info') }}"
        });
    </script>
@endif
@if (session('warning-presensi'))
    <script>
        Toast.fire({
            icon: "warning",
            title: "{{ session('warning-presensi') }}"
        });
    </script>
@endif
@yield('script-bottom')
