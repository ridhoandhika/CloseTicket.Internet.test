<section id="Main__index">
	<div id="wizard">
		<div class="_container">
			<div class="wizard" data-wizard="0" id="ask">
				<h5 class="wizard-label">Nomor Tiket Gangguan</h5>
				<input type="text" maxlength="13" class="form-control" id="ticket" placeholder="IN*******">
				<button class="btn btn-sm" id="wizard-start">submit</button>
			</div>
			<div class="wizard hide" data-wizard="1" id="create-task">
				<h5 class="wizard-label">Create Task</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="2" id="retrieve-who">
				<h5 class="wizard-label">Retrieve Who</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="2" id="retrieve-ndbyip">
				<h5 class="wizard-label">Retrieve NDByIP</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="8" id="retrieve-token1">
				<h5 class="wizard-label">Token 1</h5>
				<div class="log">
				</div>
			</div>
			<!--
			<div class="wizard hide" data-wizard="2" id="retrieve-session">
				<h5 class="wizard-label">Retrieve Session</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="3" id="retrieve-attribute">
				<h5 class="wizard-label">Retrieve Attribute</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="4" id="retrieve-decrypt">
				<h5 class="wizard-label">Retrieve Decrypt</h5>
				<div class="log">
				</div>
			</div>
			-->
			<div class="wizard hide" data-wizard="5" id="confirm">
				<h5 class="wizard-label">Tiket <span id="confirm-ticket"></span></h5>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">IP Address</span>
					</div>
					<input type="text" class="form-control" id="confirm-ipaddr" disabled>
				</div>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Source IP</span>
					</div>
					<input type="text" class="form-control" id="confirm-sourceip" disabled>
				</div>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">User ID</span>
					</div>
					<input type="text" class="form-control" id="confirm-userid" disabled>
				</div>
				<div>
					<input type="hidden" class="form-control" id="confirm-task_uid">
					<input type="hidden" class="form-control" id="confirm-session_id">
					<input type="hidden" class="form-control" id="confirm-encrypted_data">
					Apakah data di atas sudah sesuai?
					<hr />
					<button class="btn btn-sm btn-light" id="wizard-confirm-y">yes</button>
					<a href="<?php echo site_url('Main');?>" class="btn btn-sm btn-light" id="wizard-confirm-y">no</a>
				</div>
			</div>
			<div class="wizard hide" data-wizard="6" id="retrieve-ukur">
				<h5 class="wizard-label">Cek Redaman</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="7" id="stop-ukur">
				<h5 class="wizard-label">Redaman </h5>
				<div class="redaman-passed" data-passed="0">
					Jaringan Internet: Perlu perbaikan
				</div>
				<div class="redaman-passed" data-passed="1">
					Jaringan Internet: Sesuai dengan tolak ukur
					<hr />
					<button class="btn btn-sm btn-light" id="wizard-retrieve-token2">lanjut, lakukan SpeedTest</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="8" id="retrieve-token2">
				<h5 class="wizard-label">Token</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="9" id="retrieve-pcrf">
				<h5 class="wizard-label">PCRF</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="10" id="retrieve-speed">
				<h5 class="wizard-label">ACSIS</h5>
				<div class="log">
				</div>
			</div>
			<div class="wizard hide" data-wizard="11" id="stop-speed">
				<h5 class="wizard-label">SpeedTest</h5>
				<div class="speed-passed" data-passed="1">
					Layanan sesuai dengan spesifikasi &amp; usage anda sudah melewati batas.
				</div>
				<div class="speed-passed" data-passed="2">
					Layanan sesuai dengan spesifikasi.
				</div>
				<div>
					Apakah anda bersedia menutup laporan gangguan?
					<hr />
					<button class="btn btn-sm btn-light wizard-close-ticket" data-close="1">yes</button>
					<button class="btn btn-sm btn-light wizard-close-ticket" data-close="0">no</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="12" id="stop-finish">
				<h5 class="wizard-label">Selesai</h5>
				<div class="message">
					
				</div>
			</div>
			<div class="wizard hide" data-wizard="10" id="retry">
				<h5 class="wizard-label">RETRY <span id="retry-attempt"></span></h5>
				<div class="message retry">
					Error, otomatis mencoba kembali dalam <span id="retry-timer"></span>
				</div>
				<div class="message restart">
					Error, silahkan ulangi proses dari awal
					<hr />
					<a class="btn btn-sm btn-light" href="<?php echo site_url('Main');?>">mengulang proses</a>
				</div>
			</div>
		</div>
	</div>
	<div id="uid">
	</div>
</section>