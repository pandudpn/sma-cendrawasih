<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Kriteria</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <table class="display nowrap" id="tableKriteria">
                    <thead>
                        <tr>
                            <th><center>No</center></th>
                            <th><center>Nama</center></th>
														<th><center>Bobot</center></th>
														<th><center>Action</center></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('kriteria/tambah')."' style='margin-left:10px' class='btn btn-info' id='tambahKriteria'><i class='fa fa-plus fa-fw'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none; margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableKriteria').DataTable({
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
					targets: 'no-sort',
					orderable: false,
				}
	        ],
			sPaginationType: "simple_numbers", 
			iDisplayLength: 10,
			aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			ajax:{
				url :"<?php echo site_url('kriteria/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableKriteria").append('<tbody><tr><th colspan="4"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#EditKriteria', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Edit Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#tambahKriteria', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Tambah Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>


<?php $this->load->view('templates/footer'); ?>