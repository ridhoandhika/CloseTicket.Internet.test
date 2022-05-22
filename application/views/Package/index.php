<section class="Package__index">
	<div class="container-fluid">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="tab-fup" data-toggle="tab" href="#content-fup" role="tab" aria-selected="true">FUP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-quota_yes" data-toggle="tab" href="#content-quota_yes" role="tab" aria-selected="false">NON-FUP QUOTA</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-quota_no" data-toggle="tab" href="#content-quota_no" role="tab" aria-selected="false">NON-FUP NO QUOTA</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="content-fup" role="tabpanel" aria-labelledby="tab-fup">
				<div class="container-fluid">
					<div class="row">
						<div class="col-8">
							<div class="table-responsive">
								<table class="table table-bordered" id="t-fup">
									<thead>
										<tr>
											<th>Package Name</th>
											<th>Speed 1</th>
											<th>Speed 2</th>
											<th>Speed 3</th>
											<th>Usage First Boundary</th>
											<th>Usage Last Boundary</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-4">
							<div id="c-fup-new">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-fup-new-package_name" value="">
								</div>
								<div class="form-group">
									<label>Speed 1</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-new-speed_amount_1" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-new-speed_unit_1">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Speed 2</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-new-speed_amount_2" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-new-speed_unit_2">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Speed 3</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-new-speed_amount_3" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-new-speed_unit_3">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Usage First Boundary</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-new-usage_amount_2" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-new-usage_unit_2">
												<option value="G">gigabyte</option>
												<option value="M">gigabyte</option>
												<option value="K">kilobyte</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Usage Last Boundary</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-new-usage_amount_3" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-new-usage_unit_3">
												<option value="G">gigabyte</option>
												<option value="M">gigabyte</option>
												<option value="K">kilobyte</option>
											</select>
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-fup-new-save">add new</button>
							</div>
							<div id="c-fup-edit" class="hide">
								<input type="hidden" class="form-control" id="i-fup-edit-id" value="">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-fup-edit-package_name" value="">
								</div>
								<div class="form-group">
									<label>Speed 1</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-edit-speed_amount_1" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-edit-speed_unit_1">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Speed 2</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-edit-speed_amount_2" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-edit-speed_unit_2">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Speed 3</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-edit-speed_amount_3" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-edit-speed_unit_3">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Usage First Boundary</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-edit-usage_amount_2" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-edit-usage_unit_2">
												<option value="G">gigabyte</option>
												<option value="M">gigabyte</option>
												<option value="K">kilobyte</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Usage Last Boundary</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-fup-edit-usage_amount_3" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-fup-edit-usage_unit_3">
												<option value="G">gigabyte</option>
												<option value="M">gigabyte</option>
												<option value="K">kilobyte</option>
											</select>
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
			<div class="tab-pane fade" id="content-quota_yes" role="tabpanel" aria-labelledby="tab-quota_yes">
				<div class="container-fluid">
					<div class="row">
						<div class="col-8">
							<div class="table-responsive">
								<table class="table table-bordered" id="t-quota_yes">
									<thead>
										<tr>
											<th>Package Name</th>
											<th>Quota</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-4">
							<div id="c-quota_yes-new">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-quota_yes-new-package_name" value="">
								</div>
								<div class="form-group">
									<label>Quota</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-quota_yes-new-quota" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-quota_yes-new-unit">
												<option value="G">gigabyte</option>
												<option value="M">mebgabyte</option>
												<option value="K">kilobyte</option>
											</select>
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-quota_yes-new-save">add new</button>
							</div>
							<div id="c-quota_yes-edit" class="hide">
								<input type="hidden" class="form-control" id="i-quota_yes-edit-id" value="">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-quota_yes-edit-package_name" value="">
								</div>
								<div class="form-group">
									<label>Quota</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-quota_yes-edit-quota" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-quota_yes-edit-unit">
												<option value="G">gigabyte</option>
												<option value="M">mebgabyte</option>
												<option value="K">kilobyte</option>
											</select>
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-quota_yes-edit-save">update</button>
								<button class="btn btn-danger" id="b-quota_yes-edit-delete">delete</button>
								<button class="btn btn-danger" id="b-quota_yes-edit-cancel">cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="content-quota_no" role="tabpanel" aria-labelledby="tab-quota_no">
				<div class="container-fluid">
					<div class="row">
						<div class="col-8">
							<div class="table-responsive">
								<table class="table table-bordered" id="t-quota_no">
									<thead>
										<tr>
											<th>Package Name</th>
											<th>Speed</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-4">
							<div id="c-quota_no-new">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-quota_no-new-package_name" value="">
								</div>
								<div class="form-group">
									<label>Speed</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-quota_no-new-speed" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-quota_no-new-unit">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-quota_no-new-save">add new</button>
							</div>
							<div id="c-quota_no-edit" class="hide">
								<input type="hidden" class="form-control" id="i-quota_no-edit-id" value="">
								<div class="form-group">
									<label>Package Name</label>
									<input type="text" class="form-control" id="i-quota_no-edit-package_name" value="">
								</div>
								<div class="form-group">
									<label>Speed</label>
									<div class="form-row">
										<div class="col-9">
											<input type="number" class="form-control" id="i-quota_no-edit-speed" value="0">
										</div>
										<div class="col-3">
											<select class="form-control" id="i-quota_no-edit-unit">
												<option value="M">Mbps</option>
												<option value="K">Kbps</option>
											</select>
										</div>
									</div>
								</div>
								<hr />
								<button class="btn btn-danger" id="b-quota_no-edit-save">update</button>
								<button class="btn btn-danger" id="b-quota_no-edit-delete">delete</button>
								<button class="btn btn-danger" id="b-quota_no-edit-cancel">cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>