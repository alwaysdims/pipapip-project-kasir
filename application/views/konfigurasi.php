<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Konfigurasi Toko
        </h2>
    </div>

    <div class="intro-y box p-5 mt-5">

        <form action="<?= site_url('konfigurasi/update') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="old_logo" value="<?= $konfig->logo ?>">

            <div class="grid grid-cols-12 gap-6">

                <!-- Logo -->
                <div class="col-span-12 lg:col-span-4">
                    <label class="form-label">Logo Toko</label>
                    <div class="border-2 border-dashed border-slate-200 dark:border-darkmode-400 rounded-md p-5 text-center">
                        <?php if ($konfig->logo && $konfig->logo !== 'o'): ?>
                        <img src="<?= base_url('../../assets/images/' . $konfig->logo) ?>" alt="Logo" class="w-32 h-32 mx-auto object-contain mb-3">
                        <?php else: ?>
                        <div class="w-32 h-32 bg-slate-100 dark:bg-darkmode-400 mx-auto rounded-full flex items-center justify-center mb-3">
                            <i data-lucide="image" class="w-12 h-12 text-slate-500"></i>
                        </div>
                        <?php endif; ?>

                        <input type="file" name="logo" accept="image/*" class="form-control mt-3">
                        <div class="text-slate-500 text-xs mt-2">Maks. 2MB (jpg, png, jpeg, webp)</div>
                    </div>
                </div>

                <!-- Form fields -->
                <div class="col-span-12 lg:col-span-8">

                    <div class="grid grid-cols-12 gap-6">

                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">Nama Toko <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="<?= html_escape($konfig->nama) ?>" required>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">No. Telepon / WA</label>
                            <input type="text" name="no_telp" class="form-control" value="<?= html_escape($konfig->no_telp) ?>">
                        </div>

                        <div class="col-span-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= html_escape($konfig->alamat) ?></textarea>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= html_escape($konfig->email) ?>">
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label class="form-label">Selogan / Tagline</label>
                            <input type="text" name="selogan" class="form-control" value="<?= html_escape($konfig->selogan) ?>">
                        </div>

                    </div>

                </div>

            </div>

            <div class="text-right mt-8">
                <button type="submit" class="btn btn-primary w-32 mr-1 mb-2">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan
                </button>
            </div>

        </form>

    </div>
</div>
<!-- END: Content -->
