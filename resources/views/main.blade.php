<!DOCTYPE html>
<html lang="en">
@include('partials.header')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('partials.navbar')
  @include('partials.sidebar')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        @include('partials.notification')
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  @include('partials.footer')
</div>
@include('partials.scripts')
</body>
</html>