<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Inventory App</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- MASTER DATA -->
  <div class="sidebar-heading">Master Data</div>

  <!-- Barang -->
  <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('barang') }}">
      <i class="fas fa-fw fa-box"></i>
      <span>Barang</span>
    </a>
  </li>

  <!-- Kategori -->
  @if (auth()->user()->level == 'Admin')
  <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kategori') }}">
      <i class="fas fa-fw fa-tags"></i>
      <span>Kategori</span>
    </a>
  </li>
  @endif

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- PURCHASING -->
  <div class="sidebar-heading">Purchasing</div>

  <!-- Purchase Request -->
  <li class="nav-item {{ request()->is('pr*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pr.index') }}">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Purchase Request</span>
    </a>
  </li>

  <!-- Purchase Order -->
  <li class="nav-item {{ request()->is('po*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('po.index') }}">
      <i class="fas fa-fw fa-file-contract"></i>
      <span>Purchase Order</span>
    </a>
  </li>

  <!-- Goods Receipt -->
  <li class="nav-item {{ request()->is('gr*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('gr.index') }}">
      <i class="fas fa-fw fa-clipboard-check"></i>
      <span>Goods Receipt</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- LAPORAN -->
  <div class="sidebar-heading">Laporan</div>

  <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laporan.index') }}">
      <i class="fas fa-fw fa-file-pdf"></i>
      <span>Laporan PDF</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
