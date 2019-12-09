<?php if($cek->num_rows() > 0){ ?>
    <h2 class="text-center text-danger">Tidak ada Data atau Periode tersebut sudah dilakukan pemilihan.</h2>
<?php }else{ 
    if($hasil->num_rows() > 0){ ?>
        <?= form_open('analisa/hasilkeputusan/'.$tahun, array('id' => 'formKeputusan')); ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>No</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Nilai Akhir</center></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach($hasil->result() as $row){ ?>
                <tr>
                    <td><center><?= $no++; ?></center></td>
                    <td><center><?= $row->nama_guru; ?></center></td>
                    <td><center><?= number_format($row->nilai_akhir, 2, ',','.'); ?></center></td>
                    <td>
                        <center>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="<?= $row->id_guru; ?>" name="guru" class="custom-control-input" value="<?= $row->id_guru; ?>">
                            <label class="custom-control-label" style="margin-top: 3px;" for="<?= $row->id_guru; ?>">Pilih</label>
                        </div>
                        </center>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-primary pull-right" type="submit" id="simpan">Simpan Data</button>
        <?= form_close(); ?>
    <?php }else{ ?>
        <h2 class="text-center text-danger">Tidak ada Data atau Periode tersebut sudah dilakukan pemilihan.</h2>
<?php }
} ?>
<script>
    $(document).ready(function(){
        $('#formKeputusan').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#simpan').html('<i class="mdi mdi-spin mdi-loading"> Menunggu respon server....</i>');
                    $('#simpan').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status === 'success'){
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<a href="<?= base_url(); ?>analisa/pilih" class="btn btn-primary">Ok</a>');
                            $('#ModalGue').modal('show');
                        }
                    }, 2000);
                },
                error: function(){
                    $('#ModalHeader').html('Berhasil');
                    $('#ModalContent').html("<font style='color:red;' size='3'>Terjadi Kesalahan, silahkan cek kembali</font>");
                    $('#ModalFooter').html('<a href="<?= base_url(); ?>analisa/pilih" class="btn btn-secondary">Ok</a>');
                    $('#ModalGue').modal('show');
                    $('#simpan').html('Simpan Data');
                    $('#simpan').removeClass('disabled');
                }
            })
        })
    })
</script>