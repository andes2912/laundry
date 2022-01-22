<div id="header" class="header navbar navbar-default navbar-fixed-top">
  <!-- begin container -->
  <div class="container">
      <!-- begin navbar-header -->
      <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a href="{{url('/')}}" class="navbar-brand">
              <span class="navbar-logo"></span>
              <span class="brand-text">
                  {{$setpage != NULL ? $setpage->judul : 'Judul Disini'}}
              </span>
          </a>
      </div>
      <!-- end navbar-header -->
      <!-- begin #header-navbar -->
      <div class="collapse navbar-collapse" id="header-navbar">
          <ul class="nav navbar-nav navbar-right">
              @auth
              <li> <a href="{{url('/home')}}">Welcome, {{Auth::user()->name}}</a> </li>
              @else
              <li><a href="{{route('login')}}">Masuk</a></li>
              @endauth
          </ul>
      </div>
      <!-- end #header-navbar -->
  </div>
  <!-- end container -->
</div>