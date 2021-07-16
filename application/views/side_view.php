<script type = "text/javascript">
	$(document).ready(function () {
         
    });
	
</script>
<aside>
	<div class = "navbar-default sidebar">
		<div class = "sidebar-nav navbar-collapse">
			<div class = "nav side-nav-white" style = "background-color: #b3b3b3;" id = "side-menu">
				<ul class = "list-unstyled">									
					<li class = "profile">
						<a href = "javascript:void(0);">
							<div class = "avatar">
								<?php
									error_reporting(E_ALL & ~E_NOTICE);
									$user_id	= $this->session->userdata('user_id');									
									$menu		= $this->db->query("SELECT foto,nama FROM m_user WHERE user_id = $user_id");																		
									$data   	= array();
									foreach($menu->result_array() as $row){
										//echo $row['nama_menu'];	
										if($row['foto'] == '')
										{
								?>		
											<img src = "<?php echo base_url().'/assets/img/NA.jpg'; ?>" >
								<?php
										}
										else
										{
								?>
											<img src = "<?php echo base_url().'/upload/'.$row['foto']; ?>" >
								<?php
										}
									}
								?>
							</div>
							<div class = "info"><b><?php echo strtoupper($this->session->userdata('nama')); ?></b></div>
						</a>
					</li>
				</ul>	
				<ul class="list-unstyled sidebar-left">
				<?php
					error_reporting(E_ALL & ~E_NOTICE);
					$user_id	= $this->session->userdata('user_id');
					$menu		= $this->db->query("SELECT a.menu_id, a.menu_parent_id, a.nama_menu FROM m_menu a
													WHERE
														EXISTS (
															SELECT 1 FROM v_user_menu b WHERE a.menu_id = b.menu_parent_id AND b.user_id = $user_id
														) AND
														a.menu_parent_id = 0");
					$data   =   array();
					foreach($menu->result_array() as $row){
						//echo $row['nama_menu'];	
				?>
					<li><a href="javascript:void(0);"><i class="zmdi zmdi-collection-text"></i> <?php echo $row['nama_menu']; ?> <span class="zmdi zmdi-plus"  data-toggle="collapse" data-target="#menu_<?php echo $row['menu_id']; ?>"></span></a>
						<ul class="nav nav-second-level" id = "menu_<?php echo $row['menu_id']; ?>" class = "collapse">
						<?php
							error_reporting(E_ALL & ~E_NOTICE);
							$user_id	= $this->session->userdata('user_id');
							$child		= $this->db->query("SELECT * FROM v_user_menu WHERE user_id = $user_id AND menu_parent_id = '".$row['menu_id']."'");
							$data   	=   array();
							foreach($child->result_array() as $childs){
								//echo $row['nama_menu'];	
						?>
							<li><a href = "<?php echo base_url().$childs['url_path']; ?>"><i class = "<?php echo $childs['icon']; ?>"></i> <?php echo $childs['nama_menu']; ?></a></li>
						<?php } ?>
						</ul>
					</li>
				<?php
					}
				?>
				</ul>
			</div>
		</div>
	</div>
</aside>
