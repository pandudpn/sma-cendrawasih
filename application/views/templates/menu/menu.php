<?php $controller = $this->router->fetch_class(); ?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li class="treeview <?php if($controller == 'pegawai' || $controller == 'kriteria' || $controller == 'subkriteria' || $controller == 'periode'){echo 'active';} ?>">
    <a href="#">
      <i class="fa fa-file-text-o"></i>
      <span>Data Master</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-down pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php if($controller == 'guru'){echo 'active';} ?>"><a href="<?php echo base_url(); ?>guru"><i class="fa fa-user-circle"></i> Guru</a></li>
      <li class="<?php if($controller == 'kriteria'){echo 'active';} ?>"><a href="<?php echo base_url(); ?>kriteria"><i class="fa fa-pencil-square-o"></i> Kriteria</a></li>
      <li class="<?php if($controller == 'subkriteria'){echo 'active';} ?>"><a href="<?php echo base_url(); ?>subkriteria"><i class="fa fa-list-alt"></i> Sub Kriteria</a></li>
      <li class="<?php if($controller == 'periode'){echo 'active';} ?>"><a href="<?php echo base_url(); ?>periode"><i class="fa fa-calendar-o"></i> Periode</a></li>
    </ul>
  </li>
  <?php if($this->session->userdata('akses') != 2){ ?>
    <li class="treeview <?php if($controller == 'analisa')echo 'active'; ?>">
    <a href="#">
      <i class="fa fa-bar-chart"></i>
      <span>Analisa</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-down pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php if($this->uri->segment(2) == 'hitung')echo 'active'; ?>"><a href="<?php echo base_url('analisa/hitung'); ?>"><i class="fa fa-calculator"></i> Perhitungan</a></li>
      <li class="<?php if($this->uri->segment(2) == 'pilih')echo 'active'; ?>"><a href="<?php echo base_url('analisa/pilih'); ?>"><i class="fa fa-bookmark"></i> Keputusan Terbaik</a></li>
      <li class="<?php if($this->uri->segment(2) == 'guruterbaik')echo 'active'; ?>"><a href="<?php echo base_url('analisa/guruterbaik'); ?>"><i class="fa fa-print"></i> Cetak Guru Terbaik</a></li>
    </ul>
  </li>
  <?php } ?>
  <li class="treeview <?php if($controller == 'laporan')echo 'active'; ?>">
    <a href="#">
      <i class="fa fa-files-o"></i>
      <span>Laporan</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-down pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php if($this->uri->segment(2) == 'ranking')echo 'active'; ?>"><a href="<?php echo base_url('laporan/ranking'); ?>"><i class="fa fa-sort-amount-asc"></i> Ranking</a></li>
      <li class="<?php if($this->uri->segment(2) == 'kinerja')echo 'active'; ?>"><a href="<?php echo base_url('laporan/kinerja'); ?>"><i class="fa fa-list"></i> Kinerja</a></li>
      <li class="<?php if($this->uri->segment(2) == 'karyawanterbaik')echo 'active'; ?>"><a href="<?php echo base_url('laporan/karyawanterbaik'); ?>"><i class="fa fa-bookmark"></i> Keputusan Terbaik</a></li>
    </ul>
  </li>
  <li>
    <a href="<?php echo base_url(); ?>home/logout">
      <i class="fa fa-power-off"></i> <span>Logout</span>
    </a>
  </li>
</ul>