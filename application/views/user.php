<!-- BEGIN: Content -->
<div class="content">
    <div id="header-footer-modal" class="p-5">
        <div class="preview">
            <!-- BEGIN: Modal Toggle -->
            <div class="text-left"> 
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#insert-modal" class="btn btn-primary">Tambah user</a> 
            </div>
            <!-- END: Modal Toggle -->
            <!-- BEGIN: Modal Content -->
            <div id="insert-modal" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Insert user</h2>
                        </div>
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <form action="<?= base_url('user/store') ?>" method="post">
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="modal-form-1" class="form-label">Username</label>
                                    <input id="modal-form-1" type="text" class="form-control" name="username" placeholder="Username">
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Password</label>
                                    <input id="modal-form-2" type="password" name="password" class="form-control" placeholder="*********">
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Confirm Password</label>
                                    <input id="modal-form-2" type="password" name="confirm_password" class="form-control" placeholder="*********">
                                </div>
                            </div>
                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button type="submit" class="btn btn-primary w-20">Submit</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Modal Content -->
        </div>
    </div>
    <div class="overflow-x-auto mt-2 box p-5">
        <table id="example" class="stripe" style="width:100%">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Username</th>
                    <th class="whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach($users as $data){
                ?>
                <tr>
                    <td class="whitespace-nowrap"><?= $no++ ?></td>
                    <td class="whitespace-nowrap"><?= $data->username ?></td>
                    <td class="whitespace-nowrap">
					<div class="flex items-center justify-start">
						<a href="javascript:;" class="flex items-center mr-3" data-tw-toggle="modal" data-tw-target="#edit-modal-<?= $data->id ?>"> 
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1">
								<polyline points="9 11 12 14 22 4"></polyline>
								<path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
							</svg> Edit 
						</a>
						<a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-<?= $data->id ?>"> 
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
								<polyline points="3 6 5 6 21 6"></polyline>
								<path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
								<line x1="10" y1="11" x2="10" y2="17"></line>
								<line x1="14" y1="11" x2="14" y2="17"></line>
							</svg> Delete 
						</a>
					</div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit and Delete Modals -->
    <?php foreach($users as $data){ ?>
    <div id="edit-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit user</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('user/edit/' . $data->id) ?>" method="post">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Username</label>
                            <input id="modal-form-1" type="text" class="form-control" name="username" placeholder="Username" value="<?= $data->username ?>">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-2" class="form-label">Password</label>
                            <input id="modal-form-2" type="password" name="password" class="form-control" placeholder="*********">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-2" class="form-label">Confirm Password</label>
                            <input id="modal-form-2" type="password" name="confirm_password" class="form-control" placeholder="*********">
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Submit</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>

    <div id="delete-confirmation-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Konfirmasi hapus user!</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('user/delete/' . $data->id) ?>" method="post">
                    <div class="modal-body">
                        <p>Apakah kamu yakin ingin menghapus "<strong><?= $data->username ?></strong>"?</p>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-danger w-20">Delete</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<!-- END: Content -->
