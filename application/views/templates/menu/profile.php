<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="<?php echo base_url('assets/foto/user/avatar5.png'); ?>" class="img-circle" alt="Foto Profile" style="width:23px; height:23px; margin-top: -7px;">
    <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
      <img src="<?php echo base_url('assets/foto/user/avatar5.png'); ?>" class="img-circle" alt="Foto Profile">
      <p>
        <?php
        echo $login['nama'];
        $tgl = date_create($login['ts_user']);
        ?>
        <small>
          <b>
            <?php
            if($login['hak_akses'] == 1){
              echo "Administrator";
            }elseif($login['hak_akses'] == 2){
              echo "Kepala Bagian";
            }else{
              echo "Manajer";
            }
            ?>
          </b> since, <?php echo date_format($tgl, 'd F Y'); ?>
        </small>
      </p>
      <br>
    </li>
    <li class="user-footer">
      <div class="pull-left">
        <a href="<?php echo base_url(); ?>" class="btn btn-default btn-flat">Profile</a>
      </div>
      <div class="pull-right">
        <a href="<?php echo base_url(); ?>home/logout" class="btn btn-default btn-flat">Sign out</a>
      </div>
    </li>
  </ul>
</li>