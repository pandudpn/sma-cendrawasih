<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Guru</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <table class="display nowrap" id="tablePegawai">
                    <thead>
                        <tr>
                            <th><center>No</center></th>
                            <th><center>Nama</center></th>
							<th><center>TTL</center></th>
							<th><center>Jabatan</center></th>
							<th><center>TMT</center></th>
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
$tambahan .= "<a href='".site_url('guru/tambah')."' style='margin-left:10px' class='btn btn-info' id='TambahPegawai'><i class='fa fa-plus fa-fw'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none; margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tablePegawai').DataTable({
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
				url :"<?php echo site_url('guru/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tablePegawai").append('<tbody><tr><th colspan="6"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#Hapus', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus ini?');
		$('#ModalFooter').html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button><button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"'>Ya, saya yakin</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
			beforeSend: function(){
				$('#Notifikasi').html('<i class="mdi mdi-spin mdi-loading"> Memproses data....</i>');
				$('#Notifikasi').fadeIn('fast').show();
			},
			success: function(data){
				setTimeout(function(){
					if(data.status === 'success'){
						$('#Notifikasi').html(data.pesan);
						$("#Notifikasi").fadeIn('fast').show().delay(4000).fadeOut('slow');
						$('#tablePegawai').DataTable().ajax.reload( null, false );
					}
				}, 2000);
			}
		});
	});

	$(document).on('click', '#Edit', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Edit Guru');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#TambahPegawai', function(e){
		e.preventDefault();
		
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-md');
		$('#ModalHeader').html('Tambah Guru');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

	$(document).on('keyup', '#nip', function(){
		var nip = $(this).val();
		$.ajax({
			url: '<?php echo base_url("guru/ajax_cek_nip"); ?>',
			type: 'POST',
			cache: false,
			data: 'nip='+nip,
			dataType: 'json',
			success: function(json){
				if(json.status == 0){
					$('#cek_nip').html(json.pesan);
					$('#Yes').addClass('disabled');
				}
				if(json.status == 1){
					$('#cek_nip').html('');
					$('#Yes').removeClass('disabled');
				}
			}
		});
	});
</script>


<?php $this->load->view('templates/footer'); ?>