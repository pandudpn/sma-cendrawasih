<?php $this->load->view('templates/header'); ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Keputusan Karyawan Terbaik</h3>
        </div>
        <div class="box-body">
            <!-- form -->
            <?= form_open('analisa/hasilkeputusan', array('id' => 'formPilih')); ?>
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
                    <button class="btn btn-primary" id="cari" type="submit">Cari Data</button>
                </div>
            </div>
            <?= form_close(); ?>
            <!-- .// form -->
            <br>
            <div id="result"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#formPilih').submit(function(e){
            e.preventDefault();

            var tahun = $('#periode').val();
            var URL   = "<?php echo base_url(); ?>analisa/hasilkeputusan/"+tahun;

            $('#result').load(URL);
        })
    });
</script>

<?php $this->load->view('templates/footer'); ?>