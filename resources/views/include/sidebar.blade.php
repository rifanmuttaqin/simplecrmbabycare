<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <a href="{{route('home')}}">BABY SPA</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{route('home')}}">BS</a>
    </div>
    <ul class="sidebar-menu">

        <li>
            <a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{route('transaksi')}}"><i class="fas fa-exchange-alt"></i> <span>Transaksi</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{ route('layanan') }}"><i class="fas fa-concierge-bell"></i> <span>Layanan</span></a>
        </li>

        <li>
            <a class="nav-link" href="{{ route('customer') }}"><i class="fas fa-male"></i> <span>Pasien</span></a>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i> <span>Laporan</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="#">Transaksi</a></li>
        </ul>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('index-user')}}">Kelola User</a></li>
        </ul>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="#">Kelola Pengeluaran</a></li>
        </ul>
        </li>

    
    </ul>
</aside>