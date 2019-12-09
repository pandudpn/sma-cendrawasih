    </div>
    <div class="modal" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
            <h4 class="modal-title" id="ModalHeader"></h4>
          </div>
          <div class="modal-body" id="ModalContent"></div>
          <div class="modal-footer" id="ModalFooter"></div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php include("menu/footer.php"); ?>  

    <!-- Control Sidebar -->
    <?php include("menu/rightbar.php"); ?>  
  </div>
  <script src="<?php echo base_url(); ?>assets/raphael/raphael.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/morris.js/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url(); ?>assets/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url(); ?>assets/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url(); ?>assets/moment/min/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="<?php echo base_url(); ?>assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url(); ?>assets/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
  <!-- searching tanggal -->
  <script>
    $(document).ready(function(){
      $("#tglawal").datepicker({
          todayBtn:  true,
          format: 'yyyy-mm-dd',
          autoclose: true
      }).on('changeDate', function (selected) {
          var minDate = new Date(selected.date.valueOf());
          $('#tglakhir').datepicker('setStartDate', minDate);
      });

      $("#tglakhir").datepicker({
        todayBtn: true,
        format: 'yyyy-mm-dd',
        autoclose: true
          }).on('changeDate', function (selected) {
              var maxDate = new Date(selected.date.valueOf());
              $('#tglawal').datepicker('setEndDate', maxDate);
          });

  });
  </script>

  <!-- datatable custom -->
  <script>
    $(document).ready(function(){
      $('#example').DataTable({
        dom: 'Bftrip',
        responsive: true,
        buttons: [
        'copy', 'print', 'pdf', 'excel'
        ]
      });
    });
    $(document).ready(function(){
      $('#tablee').DataTable({
        dom: 'Bftrip',
        buttons: [
        'copy','print','pdf','excel'
        ]
      });
    });
    $(document).ready(function() {
      var sales = $('#laporanpenyewaan').DataTable( {
        order: [[1, 'asc']],
        rowGroup: {
          startRender: null,
          endRender: function ( rows, group ) {
            var totalharga = rows
            .data()
            .pluck(7)
            .reduce( function (a, b) {
              return a + b.replace(/[^\d]/g, '')*1;
            }, 0);
            totalharga = $.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display( totalharga );


            return $('<tr/>')
            .append( '<td colspan=7><center>'+group+'</center></td>' )
            .append( '<td><center>'+totalharga+'</center></td>' );
          },
          dataSrc: 5

        }
      } );
      //untuk mempastikan data order ketika datasrc di update
      sales.on( 'rowgroup-datasrc', function ( e, dt, val ) {
        sales.order.fixed( {pre: [[ val, 'asc' ]]} ).draw();
      } );

      $('a.group').on( 'click', function (e) {
        e.preventDefault();

        sales.rowGroup().dataSrc( $(this).data('column') );
      } );
    } );
  </script>
</body>
</html>