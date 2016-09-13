<!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="//cdn.ckeditor.com/4.5.4/full/ckeditor.js"></script>
<script src="{{ url('quickadmin/js') }}/bootstrap.min.js"></script>
<script src="{{ url('quickadmin/js') }}/main.js"></script>-->

 <script src="{{ asset('/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <script src="{{ asset('/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <!-- jQuery UI 1.11.2 -->
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
       $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('/admin-lte/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('/admin-lte/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ asset('/admin-lte/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ asset('/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('/admin-lte/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('/admin-lte/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="{{ asset('/admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ asset('/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ asset('/admin-lte/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- admin-lte App -->
    <script src="{{ asset('/admin-lte/dist/js/app.min.js') }}" type="text/javascript"></script>

    <!-- admin-lte dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('/admin-lte/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>

    <!-- admin-lte for demo purposes -->
    <script src="{{ asset('/admin-lte/dist/js/demo.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/admin-lte/plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

    <!-- AdminLTE for demo purposes -->


<script>

    $('.datepicker').datepicker({
        autoclose: true,
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}"
    });

    $('.datetimepicker').datetimepicker({
        autoclose: true,
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}",
        timeFormat: "{{ config('quickadmin.time_format_jquery') }}"
    });

    $('#datatable').dataTable( {
        "language": {
            "url": "{{ trans('quickadmin::strings.datatable_url_language') }}"
        }
    });
</script>
