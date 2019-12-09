<table class="display nowrap" id="tableRanking">
    <thead>
        <tr>
            <th><center>No</center></th>
            <th><center>Nama Pegawai</center></th>
            <th><center>Nilai Akhir</center></th>
        </tr>
    </thead>
</table>
<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('laporan/cetakRanking/'.$periode)."' style='margin-left:10px' class='btn btn-primary' target='_blank'><i class='fa fa-print'></i> Print</a>";
?>
<script>
    $(document).ready(function() {
        var periode = "<?= $periode; ?>";
		var dataTable = $('#tableRanking').DataTable({
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
				url :"<?php echo site_url('laporan/showRanking'); ?>/"+periode,
				type: "post",
				error: function(){ 
					$("#tableRanking").append('<tbody><tr><th colspan="3"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});
</script>