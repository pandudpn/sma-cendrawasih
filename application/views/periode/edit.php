<?php echo form_open('periode/edit/'.$id, array('id' => 'periode')); ?>
<div class="form-group row">
    <label for="nama" class="control-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" name="nama" placeholder="Nama Periode" id="nama" value="<?= $periode->nama_periode; ?>">
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
                url: $('#periode').attr('action'),
                type: 'POST',
                data: $('#periode').serialize(),
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
                            $('#tablePeriode').DataTable().ajax.reload(null, false);
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