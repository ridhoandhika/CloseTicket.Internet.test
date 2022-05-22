<section class="Dashboard__index">
	<div class="container-fluid">
		<div class="row">
			<div class="col-2">
				<div id="ticket-search-form">
					<div class="input-group mb-3">
					<?php
						if($this->session->userdata('SignedRole') == 'ditcons') {
					?>

						<input type="text" class="form-control form-control-sm" placeholder="INXXXX" id="ticket-search-ticket-adm">
					<?php
						}
					?>
					<?php
						if($this->session->userdata('SignedRole') != 'ditcons') {
					?>
						<input type="text" class="form-control form-control-sm" placeholder="INXXXX" id="ticket-search-ticket">
					<?php
						}
					?>
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" id="ticket-search-submit">Search Ticket</button>
						</div>
					</div>
				</div>
				

				<?php
					if($this->session->userdata('SignedRole') == 'ditcons') {
				?>
					<div id="nd-search-form">
						<div class="input-group mb-3">
							<input type="text" class="form-control form-control-sm" placeholder="123456789" id="search-nd">
							<div class="input-group-append">
								<button class="btn btn-primary" type="button" id="nd-search-submit">Search ND</button>
							</div>
						</div>
					</div>
				<?php
					}
				?>
				<div id="xls-search-form">
					<div class="input-group mb-3">
						<form action="<?php echo site_url('report/xls_summary');?>" method="POST" target="_blank" id="xls-form">
							<input type="text" class="form-control form-control-sm" name="xls-filter-start" id="xls-filter-start" value="<?php echo date('Y-m-d');?>">
							
						</form>
						<button class="btn btn-primary" type="button" id="xls-submit">CSV</button>
						
						
						<div class="input-group-append">
							
						</div>
					</div>
				</div>
				<?php
					if($this->session->userdata('SignedRole') == 'ditcons') {
				?>
					<div id="xls-search-form">
						<div class="input-group mb-3">
							<form action="<?php echo site_url('report/xls_summary_range');?>" method="POST" target="_blank" id="xls-form2">
								<input type="text" class="form-control form-control-sm" name="xls-filter2-start" id="filter2-start" value="<?php echo date('Y-m-d');?>">
								<input type="text" class="form-control form-control-sm" name="xls-filter2-finish" id="filter2-finish" value="<?php echo date('Y-m-d');?>">
								
							</form>
							<button class="btn btn-primary" type="button" id="xls-submit2">CSV</button>
							
							
							<div class="input-group-append">
								
							</div>
						</div>
					</div>
				<?php
					}
				?>
				<div class="chart-box">
					<div id="canvas-holder-01" class="canvas-holder">
						<canvas id="chart-area-01"></canvas>
					</div>
					<div id="chart-title-01" class="chart-title">Ticket Success Rate</div>
				</div>
				<hr />
				<!--
				<div class="chart-box">
					<div id="canvas-holder-02" class="canvas-holder">
						<canvas id="chart-area-02"></canvas>
					</div>
					<div id="chart-title-02" class="chart-title">Action on Success</div>
				</div>
				<hr />
				-->
				<div class="chart-box">
					<div id="canvas-holder-02" class="canvas-holder">
						<canvas id="chart-area-02"></canvas>
					</div>
					<div id="chart-title-02" class="chart-title">Redaman Success Rate</div>
				</div>
				<hr />
				<div class="chart-box">
					<div id="canvas-holder-03" class="canvas-holder">
						<canvas id="chart-area-03"></canvas>
					</div>
					<div id="chart-title-03" class="chart-title">Speedtest Success Rate</div>
				</div>
			</div>
			<div class="col-10">
				<div id="filter-form">
					<div class="row">
						<div class="col-4">
							<input type="text" value="<?php echo date('Y-m-d');?>" class="form-control form-control-sm datetimepicker" data-min-view="2" data-date-format="yyyy-mm-dd" id="filter-start" />
							<input type="hidden" value="<?php echo date('Y-m-d');?>" id="selected-start" />
						</div>
						<div class="col-4">
							<input type="text" value="<?php echo date('Y-m-d');?>" class="form-control form-control-sm datetimepicker" data-min-view="2" data-date-format="yyyy-mm-dd" id="filter-finish" />
							<input type="hidden" value="<?php echo date('Y-m-d');?>" id="selected-finish" />
						</div>
						<div class="col-4">
							<a href="#" class="btn btn-primary" id="filter-submit-1">filter by date hour</a>
							<a href="#" class="btn btn-primary" id="filter-submit-2">filter by date</a>
						</div>
					</div>
				</div>
				<div class="card card-table" id="card-list-1">
					<div class="card-header">
						Interval Summary by Date Hour
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-sm table-bordered" id="list-overview-1">
								<thead>
									<tr>
										<th colspan="2" rowspan="4">INTERVAL</th>
										<th colspan="2" rowspan="3">IP TELKOM</th>
										<th colspan="2" rowspan="3">WHO</th>
										<th colspan="2" rowspan="3">TOKEN</th>
										<th colspan="2" rowspan="3">ND</th>
										<th colspan="3" rowspan="2">REDAMAN</th>
										<th colspan="5">SPEEDTEST</th>
										<th colspan="2" rowspan="3">PELANGGAN</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2">PCRF</th>
										<th colspan="3">DOWNLOAD</th>
									</tr>
									<tr>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
									</tr>
									<tr>
										<th>Y</th>
										<th>N</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SPEC</th>
										<th>UNSPEC</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>LAYAK</th>
										<th>TIDAK LAYAK</th>
										<th>Y</th>
										<th>N</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2">TOTAL</th>
										<th class="n foot-whitelist">0</th>
										<th class="n foot-blacklist">0</th>
										<th class="n foot-who_success">0</th>
										<th class="n foot-who_failed">0</th>
										<th class="n foot-token_1_success">0</th>
										<th class="n foot-token_1_failed">0</th>
										<th class="n foot-nd_success">0</th>
										<th class="n foot-nd_failed">0</th>
										<th class="n foot-redaman_success_spec">0</th>
										<th class="n foot-redaman_success_unspec">0</th>
										<th class="n foot-redaman_failed">0</th>
										<th class="n foot-pcrf_success">0</th>
										<th class="n foot-pcrf_failed">0</th>
										<th class="n foot-speedtest_success_passed_1">0</th>
										<th class="n foot-speedtest_success_passed_0">0</th>
										<th class="n foot-speedtest_failed">0</th>
										<th class="n foot-close_1">0</th>
										<th class="n foot-close_0">0</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<div class="card card-table" id="card-list-2">
					<div class="card-header">
						Interval Summary by Date
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-sm table-bordered" id="list-overview-2">
								<thead>
									<tr>
										<th colspan="2" rowspan="4">INTERVAL</th>
										<th colspan="2" rowspan="3">IP TELKOM</th>
										<th colspan="2" rowspan="3">WHO</th>
										<th colspan="2" rowspan="3">TOKEN</th>
										<th colspan="2" rowspan="3">ND</th>
										<th colspan="3" rowspan="2">REDAMAN</th>
										<th colspan="5">SPEEDTEST</th>
										<th colspan="2" rowspan="3">PELANGGAN</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2">PCRF</th>
										<th colspan="3">DOWNLOAD</th>
									</tr>
									<tr>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
									</tr>
									<tr>
										<th>Y</th>
										<th>N</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SPEC</th>
										<th>UNSPEC</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>LAYAK</th>
										<th>TIDAK LAYAK</th>
										<th>Y</th>
										<th>N</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2">TOTAL</th>
										<th class="n foot-whitelist">0</th>
										<th class="n foot-blacklist">0</th>
										<th class="n foot-who_success">0</th>
										<th class="n foot-who_failed">0</th>
										<th class="n foot-token_1_success">0</th>
										<th class="n foot-token_1_failed">0</th>
										<th class="n foot-nd_success">0</th>
										<th class="n foot-nd_failed">0</th>
										<th class="n foot-redaman_success_spec">0</th>
										<th class="n foot-redaman_success_unspec">0</th>
										<th class="n foot-redaman_failed">0</th>
										<th class="n foot-pcrf_success">0</th>
										<th class="n foot-pcrf_failed">0</th>
										<th class="n foot-speedtest_success_passed_1">0</th>
										<th class="n foot-speedtest_success_passed_0">0</th>
										<th class="n foot-speedtest_failed">0</th>
										<th class="n foot-close_1">0</th>
										<th class="n foot-close_0">0</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modal-overview-detail" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"></h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card card-table" id="card-detail">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-sm table-bordered table-striped" id="detail-overview">
									<thead>
										<tr>
											<th>#</th>
											<th>uid</th>
											<th><div style="width:120px">ts</div></th>
											<th>ts_finish</th>
											<th>remote_addr</th>
											<th><div style="width:90px">bras</div></th>
											<th>ip_addr</th>
											<th>ticket</th>
											<th>token1_log_total_time</th>
											<th>ndbyip_log_total_time</th>
											<th>nd</th>
											<th>onu_rx_pwr</th>
											<th>reg_type</th>
											<th>version_id</th>
											<th>identifier</th>
											<th>redaman_log_total_time</th>
											<th>redaman_passed</th>
											<th>token2_log_total_time</th>
											<th>pcrf_log_total_time</th>
											<th>package_name</th>
											<th>quota_used</th>
											<th>speedtest_download</th>
											<th>speedtest_upload</th>
											<th>speedtest_latency_minimum</th>
											<th>speedtest_latency_jitter</th>
											<th>speed_passed</th>
											<th>close</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modal-ticket-search" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"></h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card card-table">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-sm table-bordered table-striped" id="ticket-search-result">
								<?php
								if($this->session->userdata('SignedRole') == 'ditcons') {
								?>
									<thead>
										<tr>
											<th>#</th>
											<th>uid</th>
											<th><div style="width:120px">ts</div></th>
											<th>ts_finish</th>
											<th>remote_addr</th>
											<th><div style="width:90px">bras</div></th>
											<th>ip_addr</th>
											<th>ticket</th>
											<th>token1_log_total_time</th>
											<th>ndbyip_log_total_time</th>
											<th>nd</th>
											<th>onu_rx_pwr</th>
											<th>reg_type</th>
											<th>version_id</th>
											<th>identifier</th>
											<th>redaman_log_total_time</th>
											<th>redaman_passed</th>
											<th>token2_log_total_time</th>
											<th>pcrf_log_total_time</th>
											<th>package_name</th>
											<th>quota_used</th>
											<th>speedtest_download</th>
											<th>speedtest_upload</th>
											<th>speedtest_latency_minimum</th>
											<th>speedtest_latency_jitter</th>
											<th>speed_passed</th>
											<th>close</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<?php
										}
									?>
								<?php
								if($this->session->userdata('SignedRole') != 'ditcons') {
								?>

									<thead>
										<tr>
											<th>#</th>
											<th><div style="width:120px">ts</div></th>
											<th>ts_finish</th>
											<th>ticket</th>
											<th>nd</th>
											<th>close</th>
											<th>onu_rx_pwr</th>
											<th>redaman_passed</th>
											<th>speedtest_download</th>
											<th>speedtest_upload</th>
											<th>speed_passed</th>
											<th>package_name</th>
											<th>quota_used</th>											
											<th>remote_addr</th>
											<th><div style="width:90px">bras</div></th>
											<th>ip_addr</th>
											<th>reg_type</th>
											<th>version_id</th>
											<th>identifier</th>
											<th>speedtest_latency_minimum</th>
											<th>speedtest_latency_jitter</th>
											<th>token1_log_total_time</th>
											<th>ndbyip_log_total_time</th>
											<th>redaman_log_total_time</th>
											<th>token2_log_total_time</th>
											<th>pcrf_log_total_time</th>
											<th>uid</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<?php
										}
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modal-nd-search" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"></h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card card-table">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-sm table-bordered table-striped" id="nd-search-result">
									<thead>
										<tr>
											<th>#</th>
											<th>uid</th>
											<th><div style="width:120px">ts</div></th>
											<th>ts_finish</th>
											<th>remote_addr</th>
											<th><div style="width:90px">bras</div></th>
											<th>ip_addr</th>
											<th>ticket</th>
											<th>token1_log_total_time</th>
											<th>ndbyip_log_total_time</th>
											<th>nd</th>
											<th>onu_rx_pwr</th>
											<th>reg_type</th>
											<th>version_id</th>
											<th>identifier</th>
											<th>redaman_log_total_time</th>
											<th>redaman_passed</th>
											<th>token2_log_total_time</th>
											<th>pcrf_log_total_time</th>
											<th>package_name</th>
											<th>quota_used</th>
											<th>speedtest_download</th>
											<th>speedtest_upload</th>
											<th>speedtest_latency_minimum</th>
											<th>speedtest_latency_jitter</th>
											<th>speed_passed</th>
											<th>close</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
</section>