<section class="Package__index">
	<div class="container-fluid">
		<ul class="nav nav-tabs" role="tablist">
		<div class="row" style="padding: 5px">
			<div class="col-sm-6">
				<div class="form-group">
					<input type="text" class="form-control" id="search" value="">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<input type="Button" class="form-control" id="btn-search" value="Search">
				</div>
			</div>
		</div>
			<!-- <input type="text"> -->
		</ul>
		<div class="tab-content">
			<!-- <div id="result"></div> -->
			<div class="tab-pane fade show active" id="content-fup" role="tabpanel" aria-labelledby="tab-fup">
				<div class="container-fluid">
					<div class="row">
						<div class="col-8">
							<div class="table-responsive">
								<table class="table table-bordered" id="t-fup">
									<thead>
										<tr>
											<th>Subnet</th>
											<th>BRAS ID</th>
											<th>Speedtest Ookla</th>
										</tr>
									</thead>
									<tbody id="acquisitionContent">
									</tbody>
								</table>
								
							</div>
						</div>
						<div class="col-4">
							<div id="c-fup-new">
								<div class="form-group">
									<label>Subnet</label>
									<input type="text" class="form-control" id="i-new-Subnet" value="">
								</div>
								<div class="form-group">
									<label>BRAS ID</label>
									<div class="form-row">
										<div class="col-9">
											<input type="text" class="form-control" id="i-new-bras_id" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Speedtest Ookla</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-new-speedtest" value="">
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-fup-new-save">add new</button>
							</div>
							<div id="c-fup-edit" class="hide">
								<input type="hidden" class="form-control" id="i-edit-id" value="">
								<div class="form-group">
									<label>Subnet</label>
									<input type="text" class="form-control" id="i-edit-Subnet" value="">
								</div>
								<div class="form-group">
									<label>BRAS ID</label>
									<div class="form-row">
										<div class="col-9">
											<input type="text" class="form-control" id="i-edit-bras_id" value="">
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label>speedtest</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-edit-speedtest" value="">
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-fup-edit-save">update</button>
								<button class="btn btn-danger" id="b-fup-edit-delete">delete</button>
								<button class="btn btn-danger" id="b-fup-edit-cancel">cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>