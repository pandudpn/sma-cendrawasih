<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Kriteria</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <table class="display nowrap" id="tableSub">
                    <thead>
                        <tr>
                            <th width="10%"><center>No</center></th>
                            <th><center>Nama</center></th>
							<th width="70%"><center>Nama</center></th>
							<th width="15%"><center>Action</center></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('subkriteria/tambah')."' style='margin-left:10px' class='btn btn-info' id='tambahSub'><i class='fa fa-plus fa-fw'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none; margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
        var groupColumn = 1;
		var dataTable = $('#tableSub').DataTable({
			serverSide: true,
			stateSave : false,
			bAutoWidth: true,
			oLanguage: {
				sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				sInfoFiltered: "(difilter dari _MAX_ total data)", 
				sZeroRecords: "Pencarian tidak ditemukan", 
				sEmptyTable: "Tidak ada Data di dalam Database", 
				sLoadingRecords: "Harap Tunggu...", 
				oPaginate: {
					sPrevious: "Prev",
					sNext: "Next"
				}
			},
			columnDefs: [ 
				{
					targets: groupColumn,
					visible: false
				}
	        ],
			sPaginationType: "simple_numbers", 
			iDisplayLength: 10,
			aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            drawCallback: function ( settings ) {
	        	var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
	
				api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group"><td colspan="3">'+group+'</td></tr>'
						);
	
						last = group;
					}
				} );
	        },
			ajax:{
				url :"<?php echo site_url('subkriteria/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableSub").append('<tbody><tr><th colspan="3"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#EditSub', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Edit Sub Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#tambahSub', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Tambah Sub Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>


<?php $this->load->view('templates/footer'); ?>