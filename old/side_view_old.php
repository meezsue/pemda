
<aside>
	<div class = "navbar-default sidebar">
		<div class = "sidebar-nav navbar-collapse">
			<div class = "nav side-nav-white" style = "background-color: #e6e6e6;" id = "side-menu">
				<ul class = "list-unstyled">
					<li class = "profile">
						<a href = "javascript:void(0);">
							<div class = "avatar">
								<?php
									error_reporting(E_ALL & ~E_NOTICE);
									$user_id	= $this->session->userdata('user_id');									
									$menu		= $this->db->query("SELECT foto,nama FROM m_user WHERE user_id = $user_id");
									$data   =   array();
									foreach($menu->result_array() as $row){
										//echo $row['nama_menu'];	
								?>		
									<img src = "<?php echo base_url().'/upload/'.$row['foto']; ?>" >
								<?php
									}
								?>
							</div>
							<div class = "info"><b><?php echo strtoupper($this->session->userdata('nama')); ?></b></div>
						</a>
					</li>
				</ul>	
				<?php
					error_reporting(E_ALL & ~E_NOTICE);
					$user_id	= $this->session->userdata('user_id');
					$menu		= $this->db->query("SELECT * FROM v_user_menu WHERE user_id = $user_id");
					$data   =   array();
					foreach($menu->result_array() as $row){
						//echo $row['nama_menu'];	
				?>				
				<ul class = "list-unstyled sidebar-left">
					<li>
						<a href = "<?php echo base_url().$row['url_path']; ?>"><i class = "<?php echo $row['icon']; ?>"></i> <?php echo $row['nama_menu']; ?></a>
					</li>					
				</ul>
				<?php
					}
				?>				
			</div>
		</div>
	</div>
</aside>
