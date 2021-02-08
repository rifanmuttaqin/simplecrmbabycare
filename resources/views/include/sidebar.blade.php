<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <a href="{{route('home')}}">BABY SPA</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{route('home')}}">BS</a>
    </div>
    <ul class="sidebar-menu">

        @if($active == 'home') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>

        {{-- <li>
            <a class="nav-link" href="#"><i class="fas fa-user-clock"></i><span>Penjadwalan</span></a>
        </li> --}}

        @if($active == 'transaksi') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{route('transaksi')}}"><i class="fas fa-exchange-alt"></i> <span>Transaksi</span></a>
        </li>

        @if($active == 'layanan') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{ route('layanan') }}"><i class="fas fa-concierge-bell"></i> <span>Layanan</span></a>
        </li>

        @if($active == 'customer') <li class="active"> @else <li> @endif
            <a class="nav-link" href="{{ route('customer') }}"><i class="fas fa-male"></i> <span>Pasien</span></a>
        </li>

        @if($active == 'laporan-transaksi-index' || $active == 'laporan transaksi') <li class="nav-item dropdown active"> @else <li> @endif
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i> <span>Laporan</span></a>
        <ul class="dropdown-menu">
             @if($active == 'laporan-transaksi-index') <li class="active"> @else <li> @endif 
                <a class="nav-link" href="{{route('report-transaksi')}}">LP.Transaksi</a>
            </li>
             @if($active == 'laporan transaksi') <li class="active"> @else <li> @endif 
                <a class="nav-link" href="{{route('report-print')}}">Cetak Transaksi</a>
            </li>
        </ul>
        </li>

        @if(Auth::user()->account_type == User::ACCOUNT_TYPE_ADMIN)
        <li>
        @if($active == 'user') <li class="nav-item dropdown active"> @else <li> @endif
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>User</span></a>
        <ul class="dropdown-menu">
            @if($active == 'user') <li class="active"> @else <li> @endif
                <a class="nav-link" href="{{route('index-user')}}">Kelola User</a>
            </li>
        </ul>
        </li>
        @endif

        <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
        <ul class="dropdown-menu">
            {{-- <li><a class="nav-link" href="#">Kelola Pengeluaran</a></li> --}}
        </ul>
        </li>

    
    </ul>
</aside>