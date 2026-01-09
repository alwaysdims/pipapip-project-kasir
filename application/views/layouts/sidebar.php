<?php
$segment = $this->uri->segment(1);
?>

<nav class="side-nav">
    <ul>

        <!-- DASHBOARD -->
        <li>
            <a href="<?= base_url('dashboard') ?>"
               class="side-menu <?= ($segment == 'dashboard' || $segment == '') ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="home"></i></div>
                <div class="side-menu__title">Dashboard</div>
            </a>
        </li>
        <!-- PENJUALAN -->
        <li>
            <a href="<?= base_url('penjualan') ?>"
               class="side-menu <?= ($segment == 'penjualan' || $segment == '') ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="shopping-cart"></i></div>
                <div class="side-menu__title">Penjualan</div>
            </a>
        </li>

        <!-- BAHAN -->
        <?php $bahanOpen = in_array($segment, ['bahan', 'satuan']); ?>
        <li>
            <a href="javascript:;"
               class="side-menu <?= $bahanOpen ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="truck"></i></div>
                <div class="side-menu__title">
                    Bahan-bahan
                    <div class="side-menu__sub-icon">
                        <i data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>

            <ul class="<?= $bahanOpen ? 'side-menu__sub-open' : 'side-menu__sub' ?>">
                <li>
                    <a href="<?= base_url('bahan') ?>"
                       class="side-menu <?= ($segment == 'bahan') ? 'side-menu--active' : '' ?>">
                        <div class="side-menu__icon"><i data-lucide="activity"></i></div>
                        <div class="side-menu__title">Bahan</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('satuan') ?>"
                       class="side-menu <?= ($segment == 'satuan') ? 'side-menu--active' : '' ?>">
                        <div class="side-menu__icon"><i data-lucide="activity"></i></div>
                        <div class="side-menu__title">Satuan</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- PENGELUARAN -->
        <?php $pengeluaranOpen = in_array($segment, ['pengeluaran', 'tipe']); ?>
        <li>
            <a href="javascript:;"
               class="side-menu <?= $pengeluaranOpen ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="credit-card"></i></div>
                <div class="side-menu__title">
                    Tambah Pengeluaran
                    <div class="side-menu__sub-icon">
                        <i data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>

            <ul class="<?= $pengeluaranOpen ? 'side-menu__sub-open' : 'side-menu__sub' ?>">
                <li>
                    <a href="<?= base_url('pengeluaran') ?>"
                       class="side-menu <?= ($segment == 'pengeluaran') ? 'side-menu--active' : '' ?>">
                        <div class="side-menu__icon"><i data-lucide="activity"></i></div>
                        <div class="side-menu__title">Pengeluaran</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('tipe') ?>"
                       class="side-menu <?= ($segment == 'tipe') ? 'side-menu--active' : '' ?>">
                        <div class="side-menu__icon"><i data-lucide="activity"></i></div>
                        <div class="side-menu__title">Tipe Pengeluaran</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- CUSTOMER -->
        <li>
            <a href="<?= base_url('customer') ?>"
               class="side-menu <?= ($segment == 'customer') ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="users"></i></div>
                <div class="side-menu__title">Customers</div>
            </a>
        </li>

        <!-- USER -->
        <li>
            <a href="<?= base_url('user') ?>"
               class="side-menu <?= ($segment == 'user') ? 'side-menu--active' : '' ?>">
                <div class="side-menu__icon"><i data-lucide="user"></i></div>
                <div class="side-menu__title">Users</div>
            </a>
        </li>

    </ul>
</nav>
