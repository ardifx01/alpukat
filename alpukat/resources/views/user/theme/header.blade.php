<header class="site-header">
  <div class="logo-container">
    <img src="{{ asset('front_end/images/logo_kepri.png') }}" alt="Logo Provinsi Kepulauan Riau">
    <div class="logo-text">
      <h1>Dinas Koperasi, Usaha Kecil dan Menengah</h1>
      <p>Dompak, Kec. Bukit Bestari, Kota Tanjungpinang, Kepulauan Riau</p>
    </div>
  </div>

  <nav class="main-nav">
    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Beranda</a>
    <a href="{{ route('user.create') }}" class="{{ request()->routeIs('user.create') ? 'active' : '' }}">Pengajuan</a>
    <a href="{{ route('user.lihat_berkas') }}" class="{{ request()->routeIs('user.lihat_berkas') ? 'active' : '' }}">Lihat Berkas</a>

    @php
    $jumlahNotif = auth()->check() ? (int) auth()->user()->notifikasi()->where('dibaca', false)->count() : 0;
    @endphp

    <a href="{{ route('user.notifikasi') }}" class="{{ request()->routeIs('user.notifikasi') ? 'active' : '' }}">
      Notifikasi
      @if($jumlahNotif > 0)
      <span class="badge text-bg-danger">{{ $jumlahNotif }}</span>
      @endif
    </a>

    @guest
    <a href="{{ route('login') }}" class="login-btn {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
    <a href="{{ route('register') }}" class="sign-up {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
    @endguest

    @auth
    <div class="profile-dropdown">
      <button class="profile-btn" id="profileDropdownBtn" type="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user-circle" style="font-size:22px;"></i>
        {{ Auth::user()->name ?? 'Profil' }}
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="profile-menu" id="profileDropdownMenu" role="menu" aria-labelledby="profileDropdownBtn">
        <a href="{{ route('profile.show') }}"><i class="fa fa-user"></i> Profil User</a>
        {{-- <a href="{{ route('profile.edit') }}"><i class="fa fa-user"></i> Edit Profil </a> --}}
        <form action="{{ route('logout') }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin logout?')">
          @csrf
          <button type="submit" style="color:#e74c3c;width:100%;text-align:left;padding:8px 16px;cursor:pointer;">
            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
          </button>
        </form>
      </div>
    </div>
    @endauth
  </nav>
</header>