<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/dashboard" class="nav-link">Home</a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
  </ul>
  <ul class="navbar-nav ml-auto">
  @if (!Auth::check() || Auth::user()->level != 'admin')
    <li class="nav-item mr-auto">
      <a href="/sesi" class="btn btn-secondary">Login</a>
    </li>
  @endif
  </ul>
</nav>