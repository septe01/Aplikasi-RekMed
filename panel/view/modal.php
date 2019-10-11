<!-- Edit Modal untuk semua -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
</div>


<!-- PERIZINAN -->
<div id="recent" class="modal fade">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">DAILY LIST & NOTE</h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
			<div class="form-group">
				<div class="row">
					<div class="col-md-3">
					<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<input type="text" data-mask="99-99-9999" name="note_date" class="form-control" value="<?php echo date('d-m-y')?>">
					</div>
					<div class="col-sm-6">
						<select class="form-control" name="note_type">
						<option>Reminder</option>
						<option>Todo</option>
						</select>
					</div>
					</div>
					</div>
					<div class="form-group">
						<input type="text" placeholder="Perihal dokumen" name="note_perihal" class="form-control">
					</div>
					<textarea rows="4" cols="5" class="form-control" placeholder="Detail" name="note_detail"></textarea>
					</br>
					<div class="btn-group">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" name="todo" class="btn btn-primary">Simpan</button>
					</div>
					</div>
					
				
			<div class="col-md-9">
			<table id="example" class="table datatable-basic table-bordered table-striped table-hover">
				<thead>
				<tr>
				<th>Date</th>
				<th>Tentang</th>
				<th>Detail</th>
				<th>Category</th>
				</tr>
				</thead>
				<?php
				$table = "note";$fild  = "*"; 
				$query = $user->select($table,$fild);?>
				<tbody>
				<?php while ($row=$query->fetch(PDO::FETCH_ASSOC)){?>
				<tr>
					<td><?php echo $row['note_date'];?></td>
					<td><?php echo $row['note_perihal'];?></td>
					<td><?php echo $row['note_detail'];?> <a class='open_modal' id='<?php echo $row['id']; ?>' name='surat_struktur'><i class="fa fa-pencil-square-o"></i></a></td>
					<td>
					<span class="label label-table label-<?php $warna = $row['note_type'];
					if ($warna=="Reminder")
					{echo "success";}
					else  if ($warna=="Todo")
					{echo "danger";}?>"><?php echo $row['note_type'];?>
					</span>
					</td>
				</tr>
				<?php }?>	
				</tbody>
			</table>
			</div>
			</div>
			<div class="modal-footer">
			</div>
			</div>
				</div>
		</form>
		</div>
	</div>
</div>
<!-- /perizinan-->

<?php if ($last_word=='perizinan' or $string){?>
<!-- PERIZINAN -->
<div id="addperizinan" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">PERIZINAN</h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Tanggal</label>
						<input type="text" placeholder="dd-mm-yyyy" data-mask="99-99-9999" name="tgl" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Perihal</label>
						<input type="text" placeholder="Perihal dokumen" name="perihal" class="form-control">
					</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Type</label>
						<input type="text" placeholder="Tentang" name="type" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Lampirkan File</label>
						<input type="text" name="file" class="form-control">
						<input type="hidden" name="filess" class="file-styled">
					</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="perizinan" class="btn btn-primary">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /perizinan-->
<?php } if ($last_word=='kontrak' or $string){?>
<!-- kontrak -->
<div id="addkontrak" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title"><?php echo strtoupper($nama)?></h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Tanggal</label>
						<input type="text" placeholder="dd-mm-yyyy" data-mask="99-99-9999" name="tgl" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Perihal</label>
						<input type="text" placeholder="Perihal dokumen" name="nama" class="form-control">
					</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Type</label>
						<input type="text" placeholder="Tentang" name="keterangan" class="form-control">
		</div>
					<div class="col-sm-6">
						<label>Lampirkan File</label>
						<input type="text" name="file" class="form-control">
						<input type="hidden" name="filess" class="file-styled">
					</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="kontrak" class="btn btn-primary">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /kontrak-->
<?php } if ($last_word=='struktur-surat' or $string){?>
<!-- surat -->
<div id="addsurat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title"><?php echo strtoupper($nama)?></h6>
			</div>
		<form autocomplete="off" method="post" action="class/class.add.php">
			<div class="modal-body"> 
			<div class="row"> 
				<div class="col-md-6"> 
					<div class="form-group"> 
                    <label for="field-2" class="control-label">No. Surat</label> 
					<input class="form-control" name="nomer" type="text" />
                    </div> 
                </div> 
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Tanggal</label> 
					<input class="form-control" name="date" type="text" data-mask="99-99-9999"/>
                </div> 
				</div>
			</div> 
			<div class="row"> 
				<div class="col-md-12"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Perihal</label> 
					<input class=" form-control" name="perihal" type="text" />
                    </div> 
				</div> 
			</div> 
			<div class="row"> 
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Disimpan di</label> 
					<input class=" form-control" name="lokasi" type="text" />
                    </div> 
				</div>
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Type</label> 
					<select class="form-control" name="keterangan">
						<option>Surat Masuk</option>
						<option>Surat Keluar</option>
					</select>
				</div> 
				</div>
			</div> 
		</div>
        <div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="surat" class="btn btn-primary">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /surat-->
<?php } if ($last_word=='struktur-izin'){?>
<!-- izin -->
<div id="addizin" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title"><?php echo strtoupper($nama)?></h6>
			</div>
		<form method="post" action="class/class.add.php">
		 <div class="modal-body"> 
			<div class="row"> 
				<div class="col-md-6"> 
					<div class="form-group"> 
                    <label for="field-2" class="control-label">No. Izin</label> 
					<input class="form-control" name="no_izin" type="text" data-mask="999/PIP-NKE/aaa/9999"/>
                    </div> 
                </div> 
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Lantai</label> 
					<input class="form-control" name="lantai_izin" type="text" />
                </div> 
				</div>
			</div> 
			<div class="row"> 
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Area</label> 
					<input class="form-control" name="area_izin" type="text" />
                    </div> 
				</div>
				<div class="col-md-6"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Type</label> 
					<select class="form-control" name="tipe_izin">
						<option>Pengecoran</option>
						<option>Pemasangan</option>
						<option>Bekisting</option>
						<option>Pembesian</option>
						<option>Pembongkaran</option>
					</select>
				</div> 
				</div>
			</div>
			<div class="row"> 
				<div class="col-md-12"> 
				<div class="form-group"> 
                    <label for="field-2" class="control-label">Time</label> 
					<input class=" form-control" name="date" type="text" data-mask="99-99-9999" />
                    </div> 
				</div>
			</div>
		</div>
       <div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="surat" class="btn btn-primary">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /izin-->

<?php } if ($last_word=='setting-menu'){?>
<!-- menu -->
<div id="addmenu" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">MENU</h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Menu</label>
						<input type="text" placeholder="Menu" name="menu" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Menu Link</label>
						<input type="text" placeholder="Menu Link (kosongkan bila ada submenu)" name="menu_link" class="form-control">
					</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="menu" class="btn btn-primary">Tambah</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /menu-->
<!-- submenu -->
<div id="addsubmenu" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">SUB MENU</h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Sub Menu</label>
						<input type="text" placeholder="Sub Menu" name="submenu" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Menu utama</label>
						<select class="form-control" name="menu_id">
						<?php $list = $DB_con->prepare("SELECT * FROM menu ORDER BY menu_id ASC");
						$list->execute();
						while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
						<option name="menu_id" value="<?php echo $row['menu_id']?>" ><?php echo $row['menu'];?></option>
						<?php }?>
						</select>
					</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Sub Menu Link</label>
						<input type="text" placeholder="Masukan Link (kosongkan bila ada childmenu)" name="submenu_link" class="form-control">
					</div>
					</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="submenus" class="btn btn-primary">Tambah</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /menu-->
<!-- childmenu -->
<div id="addchildmenu" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">CHILD MENU</h6>
			</div>
		<form method="post" action="class/class.add.php">
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Child Menu</label>
						<input type="text" placeholder="Sub Menu" name="childmenu" class="form-control">
					</div>
					<div class="col-sm-6">
						<label>Sub Menu</label>
						<select class="form-control" name="submenu_id">
						<?php $list = $DB_con->prepare("SELECT * FROM submenu ORDER BY submenu_id ASC");
						$list->execute();
						while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
						<option name="menu_id" value="<?php echo $row['submenu_id']?>" ><?php echo $row['submenu'];?></option>
						<?php }?>
						</select>
					</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
						<label>Child Menu Link</label>
						<input type="text" placeholder="Masukan Link" name="childmenu_link" class="form-control">
					</div>
					</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" name="childmenu" class="btn btn-primary">Tambah</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /menu-->

<?php }?>