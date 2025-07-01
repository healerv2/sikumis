<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <div class="d-flex">
            <!-- User -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect user-step" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('img/' . auth()->user()->foto ?? '') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profil.index') }}"><i
                            class="dripicons-user d-inline-block text-muted me-2"></i>
                        Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="$('#logout-form').submit()"><i
                            class="dripicons-exit d-inline-block text-muted me-2"></i>
                        Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>
