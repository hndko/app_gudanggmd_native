// Fungsi untuk menginisialisasi plugin
$(document).ready(function() {
  // jquery datatables
  $('#basic-datatables').DataTable({
  });

  $('#basic-datatables-masuk-keluar').DataTable({
  });

  $('#basic-datatables-pending').DataTable({
  });

  $('#basic-datatables-hide-pending').DataTable({
    "bDestroy": true
  });

  $('#basic-datatables-show-pending').DataTable({
    "bDestroy": true
  });

  // datepicker
  $('.date-picker').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true
  });

  // chosen select
  $('.chosen-select').chosen();
});