<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta9
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @include('template.title')
  {{-- Style --}}
  @include('template.style')
  @stack('other-style')
  {{-- End Style --}}
</head>

<body class="sidebar-collapse sidebar-mini layout-fixed text-xs ">
  <div class="wrapper">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('images/apps/app.png')}}" alt="Logo" height="60" width="60" />
    </div> -->
    @include('template.navbar')
    @include('template.aside')

    <div class="content-wrapper">
      @yield('main-content')
    </div>

    @include('template.footer')
    @include('sweetalert::alert')
  </div>

  {{-- Script --}}
  @include('template.script')
  @stack('other-script')
  {{-- End Script --}}
  {{-- Modal --}}
  @stack('other-modal')
  {{-- End Modal --}}
</body>

</html>