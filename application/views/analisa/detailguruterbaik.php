<?php if($guru->num_rows() > 0){ ?>
<div class="col-md-12 text-right">
    <a href="<?= base_url('analisa/cetakguruterbaik/'.$periode); ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"> Cetak</i></a>
</div>
<div class="row">
    <div class="col-md-2 text-right">
        <img src="<?= base_url('assets/foto/logo.png') ?>" alt="Cendrawasih" style="width: 100px; height:100px;">
    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12 text-center">YAYASAN PENDIDIKAN DAYA DUTIKA CENDRAWASIH</div>
            <div class="col-md-12 text-center"><b>SMA CENDRAWASIH II</b></div>
            <div class="col-md-6 text-right">NPSN : 20603163</div>
            <div class="col-md-6 text-left">STATUS : TERAKREDITASI "A"</div>
            <div class="col-md-12 text-center">Komplek Deplu 74 Pondok Aren Tangerang Selatan Banten 15224</div>
            <div class="col-md-6 text-right">Tel. (021)73885659</div>
            <div class="col-md-6 text-left">Email : smacendrawasih2@yahoo.co.id</div>
        </div>
    </div>
</div>
<br><br>
<div class="col-md-12">
    <p>Pada periode <?php echo $guru->row()->nama_periode; ?> menyatakan bahwa :</p>
</div>
<br><br>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-4">Nama</div>
            <div class="col-md-1">:</div>
            <div class="col-md-7"><?php echo $guru->row()->nama_guru; ?></div>
        </div>
        <div class="row">
            <div class="col-md-4">Jabatan</div>
            <div class="col-md-1">:</div>
            <div class="col-md-7"><?php echo $guru->row()->jabatan; ?></div>
        </div>
        <div class="row">
            <div class="col-md-4">Bidang Studi</div>
            <div class="col-md-1">:</div>
            <div class="col-md-7"><?php echo $guru->row()->bidang_studi; ?></div>
        </div>
        <div class="row">
            <div class="col-md-4">Nilai Akhir</div>
            <div class="col-md-1">:</div>
            <div class="col-md-7"><?php echo $guru->row()->nilai_akhir; ?></div>
        </div>
    </div>
</div>
<br>
<div class="col-md-12">
    <p>Dinyatakan menjadi guru terbaik.</p>
</div>
<?php }else{ ?>
<div class="col-md-12 text-center">
    <h3 class="text-danger"><i>Pada periode tersebut belum ada penilaian. Silahkan buat penilaian pada periode tersebut.</i> <a href="<?= base_url('analisa/hitung'); ?>" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Menuju Penilaian</a></h3>
</div>
<?php } ?>