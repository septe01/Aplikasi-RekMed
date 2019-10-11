<div class="row justify-content-center">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>All Elements</h4>
					</div>	
					<div class="widget-body">
						<form>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama</label>
										<input name="nama" type="text" class="form-control" placeholder="masukan nama">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Password</label>
										<input name="hp" type="text" class="form-control"  placeholder="masukan no Telpon">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Status</label>
										<input name="hp" type="text" class="form-control"  placeholder="masukan no Telpon">
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" class="btn btn-primary pull-right">Tambah</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bordered d-flex align-items-center">
						<h4>User</h4>
						<div class="col col-xs-6 text-right">
							<button type="button" class="btn btn-primary btn-square mr-1 mb-2" data-toggle="modal" data-target="#basicExampleModal">Tambah User</button>
						</div>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Name User</th>
										<th>Password User</th>
										<th><span style="width:100px;">Status</span></th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i=0; $i <20 ; $i++) {  ?>
										<tr>
											<td><span class="text-primary">054-01-FR</span></td>
											<td>Lori Baker</td>
											<td>US</td>
											<td><span style="width:100px;"><span class="badge-text badge-text-small info">Paid</span></span></td>
											<td class="td-actions">
												<a href="#"><i class="la la-edit edit"></i></a>
												<a href="#"><i class="la la-close delete"></i></a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- End Row -->
			</div>
		</div>

	</div>
	<!-- Offcanvas Sidebar -->
</div>
<!-- Begin Large Modal -->
<div id="basicExampleModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">close</span>
				</button>
			</div>
			<div class="modal-body">
				<p>
					Donec non lectus nec est porta eleifend. Morbi ut dictum augue, feugiat condimentum est. Pellentesque tincidunt justo nec aliquet tincidunt. Integer dapibus tellus non neque pulvinar mollis. Maecenas dictum laoreet diam, non convallis lorem sagittis nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc venenatis lacus arcu, nec ultricies dui vehicula vitae.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- End Large Modal -->