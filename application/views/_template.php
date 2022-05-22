<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?php echo site_url('asset/bootstrap-4.3.1-dist/css/bootstrap.min.css');?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo site_url('asset/css/_template.css');?>">
		<?php foreach($style as $s) { ?>
			<link rel="stylesheet" href="<?php echo site_url('asset/css/'.$s);?>">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo site_url('asset/css/'.$file.'.css');?>">
		<title>Check</title>
		<script>
			function site_url(path) {
				return '<?php echo site_url();?>' + path;
			}
		</script>

		
	</head>
	<body>
		<div class="hide">
			<?php echo $_SERVER['SERVER_ADDR'];?>
		</div>
		<?php echo $content;?>
		<div id="logo">
			<div id="logo1-wrap">
			</div>
			<div id="logo2-wrap">
			</div>
		</div>
		<?php 
		if(
			$this->session->userdata('SignedIn') == true 
			&& (
				$this->router->fetch_class() == 'Dashboard'
				|| $this->router->fetch_class() == 'Package'
				|| $this->router->fetch_class() == 'Api'
			)
		) {
		?>
			<div id="nav">
				<a href="<?php echo site_url('Dashboard');?>" class="btn btn-primary">Dashboard</a>
				<?php
					if($this->session->userdata('SignedRole') == 'ditcons') {
				?>
					<a href="<?php echo site_url('Package');?>" class="btn btn-primary">Package</a>
					<a href="<?php echo site_url('Api');?>" class="btn btn-primary">API Check</a>
				<?php
					}
				?>
				<a href="<?php echo site_url('Dashboard/pageSignOut');?>" class="btn btn-primary">Sign Out</a>
			</div>
		<?php } ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="<?php echo site_url('asset/js/jquery-3.5.0.min.js');?>"></script>
		<script src="<?php echo site_url('asset/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js');?>"></script>
		<?php foreach($script as $s) { ?>
			<script src="<?php echo site_url('asset/js/'.$s);?>"></script>
		<?php } ?>
		<script src="<?php echo site_url('asset/js/_template.js');?>"></script>
		<script src="<?php echo site_url('asset/js/'.$file.'.js');?>?v=1.4"></script>
	</body>
</html>
