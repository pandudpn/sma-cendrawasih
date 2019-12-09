<?php echo form_open('kriteria/edit/'.$id, array('id' => 'formKriteria')); ?>
<div class="form-group row">
    <label for="nama" class="control-label col-md-3">Nama Kriteria</label>
    <div class="col-md-9">
        <input type="text" class="form-control" name="nama" placeholder="Nama Kriteria" id="nama" value="<?= $kriteria->nama_kriteria; ?>">
    </div>
</div>
<div class="form-group row">
    <label for="bobot" class="control-label col-md-3">Bobot</label>
    <div class="col-md-9">
        <input type="number" class="form-control" id="bobot" name="bobot" placeholder="Bobot Kriteria" max="9" min="0.1" step=".0001" value="<?= $kriteria->bobot; ?>">
    </div>
</div>
<?php echo form_close(); ?>
<div id="result"></div>

<script>
    $(document).ready(function(){
        var tombol = "<button type='button' class='btn btn-danger' data-dismiss='modal'>Tutup</button>";
        tombol += "<button type='button' id='Yes' class='btn btn-primary'>Simpan Data</button>";
        $('#ModalFooter').html(tombol);

        $('#Yes').click(function(e){
            e.preventDefault();
            $.ajax({
                url: $('#formKriteria').attr('action'),
                type: 'POST',
                data: $('#formKriteria').serialize(),
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
                            $('#tableKriteria').DataTable().ajax.reload(null, false);
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