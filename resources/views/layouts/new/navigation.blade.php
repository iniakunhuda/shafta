<aside class="sidebar">
    <!-- sidebar close btn -->
     <button type="button" class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i class="ph ph-x"></i></button>
    <!-- sidebar close btn -->

    <a href="/siswa/index.php" class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
        <img src="{{ asset('assets/images/logo/logo-shafta.png') }}" alt="Logo">
    </a>


    <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">
                <li class="sidebar-menu__item">
                    <a href="/siswa/index.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-squares-four"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="/siswa/raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-books"></i></span>
                        <span class="text">Lihat Raport</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="/siswa/detail-raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-book"></i></span>
                        <span class="text">Detail Raport</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>

</aside>

