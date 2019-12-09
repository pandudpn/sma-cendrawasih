<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Analisa Perhitungan</h3>
        </div>
        <div class="box-body">
            <!-- form -->
            <div class="row mt-3">
                <div class="col-md-4 col-md-offset-2 col-12">
                    <div class="form-group row">
                        <label for="ta" class="control-label col-md-4">Periode</label>
                        <div class="col-md-8">
                            <select name="ta" id="ta" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($periode AS $row){ ?>
                                <option value="<?= $row->id_periode; ?>"><?= $row->nama_periode; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group row">
                        <label for="pe" class="control-label col-md-4">Nama Guru</label>
                        <div class="col-md-8">
                            <select name="pe" id="pe" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($guru AS $gurus){ ?>
                                <option value="<?= $gurus->id_guru; ?>"><?= $gurus->nama_guru; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .// form -->
            
            <?= form_open('analisa/hitung', array('id' => 'formHitung')); ?>
            <!-- table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%"><center>No</center></th>
                        <th><center>Nama</center></th>
                        <th width="20%"><center>Nilai</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $n  = 1;
                    $o  = 1;
                    foreach($kriteria AS $row){ ?>
                        <tr>
                            <td colspan="3">
                                <b>
                                    <?= $row->nama_kriteria; ?>
                                </b>
                            </td>
                        </tr>
                        <?php foreach($subkriteria AS $data){ 
                            if($row->id_kriteria == $data->id_kriteria) { ?>
                            <tr>
                                <td><center><?= $no++; ?></center></td>
                                <td><?= $data->nama_subkriteria; ?></td>
                                <td>
                                    <center>
                                        <input type="hidden" name="guru[]" class="form-control loopPegawai" required>
                                        <input type="hidden" class="form-control loopTahun" name="periode[]" required>
                                        <input type="number" class="form-control sub_<?= $n; ?>" name="nilai[]" min="1" max="5" step="1" required>
                                        <input type="hidden" class="form-control" name="subkriteria[]" value="<?= $data->id_subkriteria; ?>">
                                        <input type="hidden" class="form-control" name="bobot[]" value="<?= $row->bobot; ?>">
                                    </center>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php $n++;} ?>
                </tbody>
            </table>
            <!-- .// table -->
            <button class="btn btn-primary pull-right" id="simpan" type="submit">Simpan Data</button>
            <?= form_close(); ?>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#ta').change(function(){
            var valu = $(this).val();
            $('input[name="periode[]"]').val(valu);
        });

        $('#pe').change(function(){
            var valu = $(this).val();
            $('input[name="guru[]"]').val(valu);
        });
    });

    $(document).ready(function(){
        $('#formHitung').submit(function(e){
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
                success:function(data){
                    setTimeout(function(){
                        if(data.status === 'success'){
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>');
                            $('#ModalGue').modal('show');
                            $('#pe').val('');
                            $('input[type="number"]').val('');
                            $('#simpan').html('Simpan Data');
                            $('#simpan').removeClass('disabled');
                        }else{
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>');
                            $('#ModalGue').modal('show');
                            $('#simpan').html('Simpan Data');
                            $('#simpan').removeClass('disabled');
                        }
                    }, 2000);
                },
                error: function(){
                    $('#ModalHeader').html('Berhasil');
                    $('#ModalContent').html(data.pesan);
                    $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>');
                    $('#ModalGue').modal('show');
                    $('#simpan').html('Simpan Data');
                    $('#simpan').removeClass('disabled');
                }
            })
        })
    })
</script>

<?php $this->load->view('templates/footer'); ?>