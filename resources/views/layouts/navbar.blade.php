<!doctype html>
<html>
<head>
  <title>@yield('title')</title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

</head>
<body>

  <!-- navigation bar -->
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 offset-sm-3 col-md-6 offset-md-3">
        
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link" href="home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="onProfile">My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="doCommunityHub">CommunityHub</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search">Job Search</a>
          </li>
          @if(\Session::get('Role')== "admin")
          <li class="nav-item">
            <a class="nav-link" href="doAdmin">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="doJob">Job</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="logout">Logout</a>
          </li>
        </ul>
        
      </div>
    </div>
  </div>
  <!-- navigation bar ends here -->


  @yield('content')
 
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    @include('layouts.footer')
</body>
</html>