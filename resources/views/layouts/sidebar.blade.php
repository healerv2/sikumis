<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>
                <li class="{{ Request::route()->getName() == 'dashboard' ? ' active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-speedometer"></i> <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->level == 1)
                    <li class="{{ request()->is('dashboard/user*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="waves-effect">
                            <i class="mdi mdi-account"></i> <span>Data User</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/user*') ? 'active' : '' }}">
                        <a href="{{ route('pasien.index') }}" class="waves-effect">
                            <i class="mdi mdi-account-box-multiple-outline"></i> <span>Data Pasien</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/suplemen*') ? 'active' : '' }}">
                        <a href="{{ route('suplemen.index') }}" class="waves-effect">
                            <i class="mdi mdi-database-plus-outline"></i> <span>Data Suplemen</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/posts*') ? 'active' : '' }}">
                        <a href="{{ route('posts.index') }}" class="waves-effect">
                            <i class="mdi mdi-wordpress"></i> <span>Konten Edukasi</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/posts*') ? 'active' : '' }}">
                        <a href="{{ route('setting-notifikasi.index') }}" class="waves-effect">
                            <i class="mdi mdi-volume-high"></i> <span>Notifikasi</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/posts*') ? 'active' : '' }}">
                        <a href="{{ route('notifikasi.massal') }}" class="waves-effect">
                            <i class="mdi mdi-volume-high"></i> <span>Notifikasi Massal</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('dashboard/laporan*') ? 'active' : '' }}">
                        <a href="{{ route('laporan.index') }}" class="waves-effect">
                            <i class="mdi mdi-file-excel"></i> <span>Laporan</span>
                        </a>
                    </li>

                    <li class="menu-title">System</li>
                    <li class="{{ request()->routeIs('dashboard/settings*') ? 'active' : '' }}">
                        <a href="{{ route('settings.index') }}" class="waves-effect">
                            <i class="mdi mdi-cog-outline"></i> <span>Settings</span>
                        </a>
                    </li>
                @else
                    <li class="{{ request()->is('dashboard/points*') ? 'active' : '' }}">
                        <a href="" class="waves-effect">
                            <i class="mdi mdi-trophy"></i> <span>Riwayat Point</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
