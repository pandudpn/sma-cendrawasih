<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cetak Hasil Keputusan Guru Terbaik</h3>
        </div>
        <div class="box-body">
            <?php echo form_open('analisa/guruterbaik', array('id' => 'formGuruTerbaik', 'class' => 'form-horizontal')); ?>
            <div class="row">
                <div class="col-md-5 col-sm-7 col-11 col-md-offset-3 col-sm-offset-1">
                    <div class="form-group">
                        <div class="row">
                            <label for="periode" class="control-label col-md-4">Periode Penilaian</label>
                            <div class="col-md-8">
                                <select name="periode" id="periode" class="form-control">
                                    <option value="" selected disabled>-</option>
                                    <?php foreach($periode AS $data){ ?>
                                    <option value="<?= $data->id_periode; ?>"><?php echo $data->nama_periode; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-1 col-1">
                    <button class="btn btn-primary" id="cari" type="submit">Cari Data</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <hr>
            <br>
            <div id="result"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#formGuruTerbaik').submit(function(e){
            e.preventDefault();
            var periode = $('#periode').val();
            $.ajax({
                type: 'POST',
                beforeSend: function(){
                    $('#cari').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#cari').addClass('disabled');
                },
                success: function(){
                    setTimeout(() => {
                        $('#cari').html('Cari Data');
                        $('#cari').removeClass('disabled');
                        var URL     = '<?php echo base_url("analisa/detailguruterbaik"); ?>/'+periode
                        $('#result').load(URL);
                    }, 1000)
                }
            })
        })
    })
</script>
<?php $this->load->view('templates/footer'); ?>