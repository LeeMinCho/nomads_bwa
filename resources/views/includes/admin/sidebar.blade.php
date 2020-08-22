<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-text mx-3">
            Nomads Admin
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->is('admin/role*') || request()->is('admin/user*') ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
          <i class="fas fa-fw fa-users"></i>
          <span>Master User</span>
        </a>
        <div id="collapseUser" class="collapse {{ request()->is('admin/role*') || request()->is('admin/user*') ? 'show' : '' }}" aria-labelledby="headingUser" data-parent="#accordionSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ request()->is('admin/role*') ? 'active' : '' }}" href="{{ route('role.index') }}">Role</a>
            <a class="collapse-item {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('user.index') }}">User</a>
          </div>
        </div>
      </li>

    <li class="nav-item {{ request()->is('admin/travel-package*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('travel-package.index') }}">
            <i class="fas fa-fw fa-hotel"></i>
            <span>Paket Travel</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/gallery*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gallery.index') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Galeri Travel</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/transaction*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaction.index') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->