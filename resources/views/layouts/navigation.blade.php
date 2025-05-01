<aside class="sidebar">
    <!-- sidebar close btn -->
     <button type="button" class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i class="ph ph-x"></i></button>
    <!-- sidebar close btn -->

    <a href="{{route('dashboard')}}" class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
        <img src="{{ asset('assets/images/logo/logo-shafta.png') }}" alt="Logo">
    </a>


    <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">
                <li class="sidebar-menu__item {{ request()->is('admin/dashboard*') ? 'activePage' : (request()->is('siswa/dashboard*') ? 'activePage' : '') }}">
                    <a href="{{route('dashboard')}}" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-squares-four"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                @if(Auth::user()->isSiswa())
                <li class="sidebar-menu__item">
                    <a href="/siswa/raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-book-open-text"></i></span>
                        <span class="text">Lihat Raport</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="/siswa/detail-raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-book"></i></span>
                        <span class="text">Detail Raport</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->hasAdminAccess())
                <li class="sidebar-menu__item {{ request()->is('admin/tahun_ajaran*') ? 'activePage' : '' }}">
                    <a href="{{ route('admin.tahun_ajaran.index') }}" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-film-script"></i></span>
                        <span class="text">Tahun Ajaran</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="siswa.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-door-open"></i></span>
                        <span class="text">Kelas</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="siswa.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-users-three"></i></span>
                        <span class="text">Siswa</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="upload-raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-book-open-text"></i></span>
                        <span class="text">Nilai Raport</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="upload-raport.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-upload"></i></span>
                        <span class="text">Upload Nilai Raport</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="kalender.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-calendar-dots"></i></span>
                        <span class="text">Kalender</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <span class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Pengaturan</span>
                </li>

                @if(Auth::user()->isSuperAdmin())
                <li class="sidebar-menu__item">
                    <a href="sekolah.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-user-check"></i></span>
                        <span class="text">Akun Admin</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="sekolah.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-user"></i></span>
                        <span class="text">Akun Siswa</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-menu__item">
                    <a href="setting.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-gear"></i></span>
                        <span class="text">Pengaturan</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>

</aside>

