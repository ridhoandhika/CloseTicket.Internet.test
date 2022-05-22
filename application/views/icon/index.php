<section id="Main__index">
	<div id="wizard">
		<div class="_container">
			<div class="wizard" data-wizard="0">
			<?php
					$nourut = "1";
					$query      =  $this->db->get('icon');
			?>

				<div class="row">
					<!-- my php code which uses x-path to get results from xml query. -->
					<?php foreach ($query->result() as $row) : ?>
							<div class="product-wrapper mb-30">
								<div class="product-img">
									<a href="<?php echo site_url('asset/img/icon/'.$row->path.'')?>">
								
										<img src="<?php echo site_url('asset/img/icon/'.$row->path.'')?>">		
								
									</a>
									<div class="text-download">
										<a href="<?php echo site_url('asset/img/icon/'.$row->path.'')?>" class="download"><span>Download</span></a>
									</div>
								</div>
							</div>				
					<?php endforeach; ?>
				
					</div>

				
				
			</div>
		 </div>
	</div>
</section>