<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Karyawan Terbaik</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <table class="display nowrap" id="tableKeputusan">
                    <thead>
                        <tr>
                            <th><center>No</center></th>
                            <th><center>Nama Pegawai</center></th>
							<th><center>Periode</center></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('laporan/cetakKeputusan')."' style='margin-left:10px' class='btn btn-primary' target='_blank'><i class='fa fa-print'></i> Print</a>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableKeputusan').DataTable({
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
				url :"<?php echo site_url('laporan/showKeputusan'); ?>",
				type: "post",
				error: function(){ 
					$("#tableKeputusan").append('<tbody><tr><th colspan="3"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});
</script>


<?php $this->load->view('templates/footer'); ?>