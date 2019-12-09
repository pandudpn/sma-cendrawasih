<div class="user-panel">
	<div class="pull-left image">
		<img src="<?php echo base_url('assets/foto/user/avatar5.png'); ?>" class="img-circle" alt="Foto Profile">
	</div>
	<div class="pull-left info">
		<p><?php echo substr($login['nama'],0,15); ?></p>
		<a href="#">
			<i class="fa fa-circle text-success"></i>
			<?php
			if($login['hak_akses'] == 1){
				echo "Administrator";
			}elseif($login['hak_akses'] == 2){
				echo "Kepala Bagian";
			}else{
				echo "Manajer";
			}
			?>
		</a>
	</div><br><br><br>
</div>