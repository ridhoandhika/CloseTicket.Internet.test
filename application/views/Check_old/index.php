<section id="Main__index">
	<div id="wizard">
		<div class="_container">
			<div class="wizard" data-wizard="0" id="ask-ticket">
				<h5 class="wizard-label">Silahkan klik submit untuk pengecekan layanan</h5>
				<button class="btn btn-sm" id="submit-ticket">submit</button>
				<div id="wrap-ticket">
					<!-- <input type="text" maxlength="13" class="form-control" id="input-ticket" > -->
					
					<div class="loader hide" id="loader-ticket">
						<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
					</div>
					<small class="form-text text-muted invisible" id="error-submit-ticket">
						Format Nomor Tiket tidak sesuai
					</small>
				</div>
				<div id="disclaimer">
					<ul>
						<li>Pastikan ONT ON, tidak isolir dan jaringan fiber</li>
						<li>Hasil speed test akan optimal jika tidak ada gadget yang terkoneksi ke ONT</li>
					</ul>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-check">
				<div id="show-confirm">
					<h5 class="wizard-label">Hasil Pengecekan Internet Anda</h5>
					<div class="input-group" hidden>
						<div class="input-group-prepend" >
							<span class="input-group-text" >Nomor Tiket</span>
						</div>
						<input type="text" class="form-control" id="confirm-ticket" readonly>
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Nomor Internet Anda</span>
						</div>
						<input type="text" class="form-control" id="confirm-nd" readonly>
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Kualitas Jaringan</span>
						</div>
						<div class="loader hide" id="loader-redaman">
							<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
						</div>
						<input type="text" class="form-control" id="confirm-redaman" readonly>
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Kecepatan Internet</span>
						</div>
						<div class="loader hide" id="loader-speed">
							<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
						</div>
						<input type="text" class="form-control" id="confirm-speed" readonly>
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Speed Test ONT</span>
						</div>
						<div class="loader hide" id="loader-speed-acsis">
							<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
						</div>
						<input type="text" class="form-control" id="confirm-speed-acsis" readonly>
					</div>
				</div>
				<div id="show-eligible">
					<div class="hide" id="show-eligible-close-y">
						<hr />
						Layanan internet anda dalam kondisi normal.<br />
						Apakah anda bersedia menutup tiket pelaporan gangguan internet Anda?
						<hr />
						<div class="container-fluid">
							<div class="row">
								<div class="col-6" style="text-align:right;">
									<button class="btn btn-sm btn-light" id="submit-close-y">YA</button>
								</div>
								<div class="col-6" style="text-align:left;">
									<button class="btn btn-sm btn-light" id="submit-close-n">TIDAK</button>
								</div>
							</div>
						</div>
					</div>
					<div class="hide" id="show-eligible-close-n">
						<br />
						<div id="disclaimer">
							Jika hasil Kecepatan Internet BELUM LAYAK, silakan melakukan pengetesan SCC Web dari Laptop/PC Pelanggan menggunakan media kabel LAN, untuk mendapatkan hasil yang mendekati ideal (khususnya pada Pelanggan Paket >= 50 Mbps)
						</div>
						<hr />
						Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
						<hr />
						<button class="btn btn-sm btn-light" id="retry-2">Ok</button>
					</div>
					<div class="hide" id="show-eligible-thanks">
						<hr />
						Terima kasih atas kepercayaan anda pada layanan IndiHome
					</div>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish">
				<div id="show-finish-failed" class="show-finish-sub">
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish-myip">
				<div id="show-finish-failed" class="show-finish-sub">
					Output dari myip tidak ditemukan
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>

			<div class="wizard hide" data-wizard="1" id="show-finish-nd">
				<div id="show-finish-failed" class="show-finish-sub">
					Nomor internet tidak ditemukan
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish-nde">
				<div id="show-finish-failed" class="show-finish-sub">
					tidak mendapatkan output dari GetND Radius
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish-rdmn">
				<div id="show-finish-failed" class="show-finish-sub">
					Redaman tidak ditemukan
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish-rdm">
				<div id="show-finish-failed" class="show-finish-sub">
					tidak mendapatkan ouput dari redaman Ibooster 
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
			<div class="wizard hide" data-wizard="1" id="show-finish-pcrf">
				<div id="show-finish-failed" class="show-finish-sub">
					tidak mendapatkan ouput dari PCRF 
					<hr />
					Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147
					<hr />
					<button class="btn btn-sm btn-light" id="retry">Ok</button>
				</div>
			</div>
		</div>
	</div>
	<div id="uid">
	</div>
	<div class="modal fade" id="ask-wait-0" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" data-backdrop="static">
			<div class="modal-content">
				<div class="modal-body">
					Belum mendapatkan nd. Bersedia menunggu?
					<hr />
					<div class="container-fluid">
						<div class="row">
							<div class="col-6" style="text-align:right;">
								<button class="btn btn-sm btn-danger" id="submit-wait-0-y">Ya</button>
							</div>
							<div class="col-6" style="text-align:left;">
								<button class="btn btn-sm btn-danger" id="submit-close-0-n">Tidak</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ask-wait-1" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" data-backdrop="static">
			<div class="modal-content">
				<div class="modal-body">
					Belum mendapatkan hasil redaman. Bersedia menunggu?
					<hr />
					<div class="container-fluid">
						<div class="row">
							<div class="col-6" style="text-align:right;">
								<button class="btn btn-sm btn-danger" id="submit-wait-1-y">Ya</button>
							</div>
							<div class="col-6" style="text-align:left;">
								<button class="btn btn-sm btn-danger" id="submit-close-1-n">Tidak</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ask-wait-2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" data-backdrop="static">
			<div class="modal-content">
				<div class="modal-body">
					Belum mendapatkan hasil PCRF. Bersedia menunggu?
					<hr />
					<div class="container-fluid">
						<div class="row">
							<div class="col-6" style="text-align:right;">
								<button class="btn btn-sm btn-danger" id="submit-wait-1-y">Ya</button>
							</div>
							<div class="col-6" style="text-align:left;">
								<button class="btn btn-sm btn-danger" id="submit-close-1-n">Tidak</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ookla-test" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					OOKLA
					<br />
					<div id="uidookla">
					</div>
					<hr />
					<div class="container-fluid">
						<iframe width="100%" height="650px" id="ookla" frameborder="0" src="" allow="geolocation *"></iframe>
					</div>
					<!--<div class="container-fluid" id="okkla2">-->
						<!--<iframe width="100%" height="650px" id="akun2" frameborder="0" src=""></iframe>-->
					<!--</div>-->
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-danger disabled" id="submit-speed">continue</a>
				</div>
				<br />
				<div id="uidooklaa">
				</div>
			</div>
		</div>
	</div>

</section>