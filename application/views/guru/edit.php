<?php echo form_open('guru/edit/'.$nip, array('id' => 'formGuru')); ?>
<div class="form-group row">
    <label for="nama" class="control-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" name="nama" value="<?= $guru->nama_guru; ?>" placeholder="Nama Panjang" id="nama">
    </div>
</div>
<div class="form-group row">
    <label for="ttl" class="control-label col-md-3">TTL</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="tempat" value="<?= $guru->tempat; ?>" name="tempat" placeholder="Tempat Lahir">
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control" id="tgl_lahir" value="<?= $guru->tgl_lahir; ?>" name="tgl_lahir" placeholder="Tanggal Lahir">
    </div>
</div>
<div class="form-group row">
    <label for="jabatan" class="control-label col-md-3">Jabatan</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="jabatan" value="<?= $guru->jabatan; ?>" name="jabatan" placeholder="Jabatan">
    </div>
</div>
<div class="form-group row">
    <label for="tmt" class="control-label col-md-3">TMT</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="tmt" name="tmt" value="<?= $guru->tmt; ?>" placeholder="TMT">
    </div>
</div>
<div class="form-group row">
    <label for="bidang" class="control-label col-md-3">Bidang Studi</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="bidang" name="bidang" value="<?= $guru->bidang_studi; ?>" placeholder="Bidang Studi Pelajaran">
    </div>
</div>
<?php echo form_close(); ?>
<div id="result"></div>

<script>
    $(document).ready(function(){
        $('#tgl_lahir').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#tmt').datepicker({
            format: 'yyyy-mm-dd'
        });
        var tombol = "<button type='button' class='btn btn-danger' data-dismiss='modal'>Tutup</button>";
        tombol += "<button type='button' id='Yes' class='btn btn-primary'>Simpan Data</button>";
        $('#ModalFooter').html(tombol);

        $('#Yes').click(function(e){
            e.preventDefault();
            $.ajax({
                url: $('#formGuru').attr('action'),
                type: 'POST',
                data: $('#formGuru').serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#Yes').html('<i class="mdi mdi-spin mdi-loading"> Menyimpan data, harga tunggu....</i>');
                    $('#Yes').addClass('disabled');
                    $('#result').html('');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status === 'success'){
                            $('#Notifikasi').html(data.pesan);
                            $('#Notifikasi').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#tablePegawai').DataTable().ajax.reload(null, false);
                            $('#ModalGue').modal('hide');
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                        }else if(data.status === 'error'){
                            $('#result').html(data.pesan);
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                        }
                    }, 1000);
                }
            });
        });
    });
</script>