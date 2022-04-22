<header class="navbar navbar-expand-md navbar-light d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
      <a href="{{url('home')}}">
        <img src="{{asset('images/company.png')}}" width="50" height="15" alt="Company" class="navbar-brand-image">
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      <a href="{{ route('logout')}}" class="nav-link px-0 hide-theme-dark" title="logout" data-bs-toggle="tooltip" data-bs-placement="bottom">
        <i class="ti ti-power"></i>
      </a>
    </div>
    {{-- Navbar --}}
    @include('template.navbar')
    {{-- End Navbar --}}
  </div>
</header>