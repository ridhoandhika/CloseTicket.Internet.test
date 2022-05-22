<section id="Main__index">
	<div id="wizard">
		<div class="_container">
			<div class="wizard" data-wizard="0" id="check-ip">
				<div id="check-ip-greet">
					<div id="check-ip-title">
						Selamat Datang di Check Internet Indihome
					</div>
					<div id="check-ip-content">
						Anda mengakses layanan ini dari IP Address <?php echo $ip;?>
					</div>
					<div id="check-ip-allowed">
						Kami akan mengarahkan ke halaman berikutnya... redirect dalam <span id="check-ip-timer"></span>
					</div>
					<div id="check-ip-forbidden">
						Anda harus mengakses menggunakan jaringan Telkom
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		let whitelist = <?php echo $whitelist;?>;
	</script>
</section>