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

  {{-- Title --}}
  @include('template.title')
  {{-- End Title --}}

  {{-- Style --}}
  @include('template.style')
  {{-- End Style --}}

  {{-- Other Style --}}
  @method('other-style')
  {{-- End Other Style --}}
</head>

<body class="layout-fluid">
  <div class=" page">
    {{-- Header --}}
    @include('template.header')
    {{-- End Header --}}
    {{-- Navbar || condensed di pindah ke header--}}
    {{-- @include('template.navbar') --}}
    {{-- End Navbar --}}
    <div class="page-wrapper">
      @yield('main-content')
    </div>
  </div>
  {{-- Script --}}
  @include('template.script')
  {{-- End Script --}}

  {{-- Other Script --}}
  @stack('other-script')
  {{-- End Other Script --}}
</body>

</html>