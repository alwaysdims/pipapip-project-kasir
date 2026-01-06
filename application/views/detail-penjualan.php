<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Invoice Layout
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button onclick="window.print()" class="btn btn-primary shadow-md mr-2">Print</button>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-plus w-4 h-4">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li><a href="" class="dropdown-item">Export Word</a></li>
                        <li><a href="" class="dropdown-item">Export PDF</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
            <div class="px-5 py-10 sm:px-20 sm:py-20">
                <div class="text-primary font-semibold text-3xl">INVOICE</div>
                <div class="mt-2"> Receipt <span class="font-medium">#<?= $transaksi->kode_transaksi ?></span> </div>
                <div class="mt-1"><?= date('d M Y', strtotime($transaksi->tanggal)) ?></div>
            </div>
        </div>

        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA JUAL</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $subtotal_all = 0;
                        foreach ($details as $dt): 
                            $subtotal = $dt->harga_jual * $dt->jumlah;
                            $subtotal_all += $subtotal;
                        ?>
                        <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap"><?= $dt->nama ?></div>
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">
                                    Harga Beli: Rp <?= number_format($dt->harga_beli, 0, ',', '.') ?>
                                </div>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32"><?= $dt->jumlah ?></td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">
                                Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">
                                Rp <?= number_format($subtotal, 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right font-medium text-lg">SUB TOTAL</td>
                            <td class="text-right font-medium text-lg">
                                Rp <?= number_format($subtotal_all, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-left mt-10 sm:mt-0">
                <div class="text-base text-slate-500">Total Bayar</div>
                <div class="text-lg text-primary font-medium mt-2">
                    Rp <?= number_format($transaksi->total,  0, ',', '.') ?>
                </div>
            </div>
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-slate-500">Kembalian</div>
                <!-- Contoh: jika ada kolom bayar di transaksi, sesuaikan -->
                <div class="text-xl text-primary font-medium mt-2">
                    <!-- Misal belum ada kolom bayar, bisa dihitung atau ditambahkan nanti -->
                    Rp 0
                </div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
</div>
