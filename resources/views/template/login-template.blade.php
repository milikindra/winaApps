
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

    {{-- Style --}}
        @include('template.style')
    {{-- End Style --}}

    {{-- Other Style --}}
    @method('other-style')
    {{-- End Other Style --}}
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    @yield('main-content')
    @include('template.script')
  </body>
</html>
