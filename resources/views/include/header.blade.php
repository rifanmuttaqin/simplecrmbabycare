<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <img class="img-profile rounded-circle" src="{{ Auth::user()->profile_picture != null ? URL::to('/').'/storage/profile_picture/'. Auth::user()->profile_picture : URL::to('/layout/assets/img/avatar.png')}}">
    <div class="d-sm-none d-lg-inline-block">{{ Auth::user() != null ? Auth::user()->nama : '' }}</div></a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{route('profile')}}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profile
        </a>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
    </div>
    </li>
</ul>
</nav>