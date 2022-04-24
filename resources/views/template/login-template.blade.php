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
  {{-- Title --}}
  @include('template.title')
  {{-- End Title --}}
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{ asset('plugins/login-admin/css/style.css')}}" rel="stylesheet" />
  {{-- Other Style --}}
  @method('other-style')
  {{-- End Other Style --}}
</head>

<body class="img js-fullheight" style="background-image: url(plugins/login-admin/images/bg.jpg);">
  @yield('main-content')

  <script src="{{ asset('plugins/login-admin/js/jquery.min.js')}}"></script>
  <script src="{{ asset('plugins/login-admin/js/popper.js')}}"></script>
  <script src="{{ asset('plugins/login-admin/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('plugins/login-admin/js/main.js')}}"></script>
  {{-- Other Script --}}
  @stack('other-script')
  {{-- End Other Script --}}
</body>

</html>