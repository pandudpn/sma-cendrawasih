<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Perankingan</h3>
        </div>
        <div class="box-body">
            <!-- form -->
            <?= form_open('laporan/ranking', array('id' => 'formRanking')); ?>
            <div class="row">
                <div class="col-md-4 col-md-offset-3">
                    <div class="form-group row">
                        <label for="periode" class="control-label col-md-3">Periode</label>
                        <div class="col-md-9">
                            <select name="periode" id="periode" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($periode AS $data){ ?>
                                <option value="<?= $data->id_periode; ?>"><?= $data->nama_periode; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit" id="cari">Cari Data</button>
                </div>
            </div>
            <?= form_close(); ?>
            <!-- .//form -->
            <br>
            <div id="result"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#formRanking').submit(function(e){
            e.preventDefault();
            
            var periode = $('#periode').val();
            var URL = "<?= base_url(); ?>laporan/detailranking/"+periode;

            $('#result').load(URL);
        })
    })
</script>

<?php $this->load->view('templates/footer'); ?>