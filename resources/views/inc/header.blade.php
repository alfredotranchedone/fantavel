
    <!-- Logo -->
    <a href="../../" class="logo"><b>Talent's Manager</b></a>

    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Menu -->
          <li class="dropdown notifications-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user fa-fw"></i> {{ ucfirst(Auth::user()->name) }}
              </a>
              <ul class="dropdown-menu">
                <li class="header">Menu Utente</li>
                <li>
                  <!-- Inner Menu: contains the notifications -->
                  <ul class="menu">
                    <li><!-- start notification -->
                      <a href="#"><i class="fa fa-gears"></i> Impostazioni</a>
                      <a href="{{ url('auth/logout') }}"><i class="fa fa-sign-out"></i> Esci</a>
                    </li><!-- end notification -->
                  </ul>
                </li>
              </ul>
            </li>

        </ul>
      </div>
    </nav>




