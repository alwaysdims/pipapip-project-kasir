<!-- BEGIN: Content -->
<div class="content">
    <div id="header-footer-modal" class="p-5">
        <div class="preview">
            <!-- BEGIN: Modal Toggle -->
            <div class="text-left"> 
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#insert-modal" class="btn btn-primary">Tambah Satuan</a> 
            </div>
            <!-- END: Modal Toggle -->
            <!-- BEGIN: Modal Content -->
            <div id="insert-modal" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Tambah Satuan Barang</h2>
                        </div>
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <form action="<?= base_url('satuan/store') ?>" method="post">
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="modal-form-1" class="form-label">Nama Satuan</label>
                                    <input id="modal-form-1" type="text" class="form-control" name="nama" placeholder="Contoh: Pcs, Kg, Liter, Box, Roll" required>
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
                    <th class="whitespace-nowrap">Nama Satuan</th>
                    <th class="whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach($satuans as $data){
                ?>
                <tr>
                    <td class="whitespace-nowrap"><?= $no++ ?></td>
                    <td class="whitespace-nowrap"><?= $data->nama ?></td>
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
    <?php foreach($satuans as $data){ ?>
    <div id="edit-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Satuan Barang</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('satuan/edit/' . $data->id) ?>" method="post">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12">
                            <label for="modal-form-1" class="form-label">Nama Satuan</label>
                            <input id="modal-form-1" type="text" class="form-control" name="nama" value="<?= $data->nama ?>" placeholder="Contoh: Pcs, Kg, Liter, Box, Roll" required>
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
                    <h2 class="font-medium text-base mr-auto">Konfirmasi Hapus Satuan</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="<?= base_url('satuan/delete/' . $data->id) ?>" method="post">
                    <div class="modal-body">
                        <p>Apakah kamu yakin ingin menghapus satuan "<strong><?= $data->nama ?></strong>"?</p>
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
