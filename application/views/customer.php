<!-- BEGIN: Content -->
<div class="content">
    <div id="header-footer-modal" class="p-5">
        <div class="preview">
            <!-- BEGIN: Modal Toggle -->
            <div class="text-left"> 
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#insert-modal" class="btn btn-primary">Tambah Customer</a> 
            </div>
            <!-- END: Modal Toggle -->
            <!-- BEGIN: Modal Content -->
            <div id="insert-modal" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Insert Customer</h2>
                        </div>
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <form action="<?= base_url('customer/store') ?>" method="post">
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-6">
                                    <label class="form-label">Customer Code</label>
                                    <input type="text" class="form-control" name="customer_code" placeholder="Customer Code" required>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-span-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat"></textarea>
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <label class="form-label">No. Telp</label>
                                    <input type="text" class="form-control" name="no_telp" placeholder="No. Telp" required>
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
                    <th class="whitespace-nowrap">Customer Code</th>
                    <th class="whitespace-nowrap">Email</th>
                    <th class="whitespace-nowrap">Alamat</th>
                    <th class="whitespace-nowrap">No. Telp</th>
                    <th class="whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach($customers as $data){
                ?>
                <tr>
                    <td class="whitespace-nowrap"><?= $no++ ?></td>
                    <td class="whitespace-nowrap"><?= $data->customer_code ?></td>
                    <td class="whitespace-nowrap"><?= $data->email ?></td>
                    <td class="whitespace-nowrap"><?= $data->alamat ?></td>
                    <td class="whitespace-nowrap"><?= $data->no_telp ?></td>
                    <td class="whitespace-nowrap">
                        <div class="flex items-center justify-start">
                            <a href="javascript:;" class="flex items-center mr-3" data-tw-toggle="modal" data-tw-target="#edit-modal-<?= $data->id ?>"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit w-4 h-4 mr-1">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg> Edit 
                            </a>
                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-<?= $data->id ?>"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 w-4 h-4 mr-1">
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
    <?php foreach($customers as $data){ ?>
    <div id="edit-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Customer</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('customer/edit/' . $data->id) ?>" method="post">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">Customer Code</label>
                            <input type="text" class="form-control" name="customer_code" value="<?= $data->customer_code ?>" readonly required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $data->email ?>" required>
                        </div>
                        <div class="col-span-12">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3"><?= $data->alamat ?></textarea>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label class="form-label">No. Telp</label>
                            <input type="text" class="form-control" name="no_telp" value="<?= $data->no_telp ?>" required>
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
                    <h2 class="font-medium text-base mr-auto">Confirm Delete</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('customer/delete/' . $data->id) ?>" method="post">
                    <div class="modal-body">
                        <p>Anda yakin akan menghapus customer dengan code "<strong><?= $data->customer_code ?></strong>"?</p>
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
