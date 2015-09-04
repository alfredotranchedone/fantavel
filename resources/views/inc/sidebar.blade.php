<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class=" info">
      <p>
          <?php $t = \App\Team::userTeam( Auth::user()->id )->first(); ?>
          @if(Auth::user()->levels_level!=0)
              @if( $t )
                {{ $t->name }}
              @else
                {{ ucfirst(Auth::user()->name) }}
              @endif

          @else
              Amministratore
          @endif
      </p>
      <!-- Status -->
      <a href="#"><i class="fa fa-envelope"></i> {{ Auth::user()->email }}</a>
    </div>
  </div>

  <!-- search form (Optional)
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Cerca..."/>
      <span class="input-group-btn">
        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
      </span>
    </div>
  </form>
    -->

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">

      @if( Auth::user()->levels_level == 0 )

        <li class="header">AMMINISTRAZIONE</li>
        <li class="{{ Menu::activeMenu('admin') }}"><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="{{ Menu::activeMenu('user') }}"><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>Utenti</span></a></li>
        <li class="{{ Menu::activeMenu('rose') }}"><a href="{{ url('admin/rose') }}"><i class="fa fa-users"></i> <span>Squadre</span></a></li>

        <li class="{{ Menu::activeMenu('classifica') }}"><a href="{{ url('admin/classifica') }}"><i class="fa fa-list"></i> <span>Classifica</span></a></li>

          <li class="treeview {{ Menu::activeMenu('calendario') }}">
           <a href="#"><i class="fa fa-calendar"></i> <span>Calendario</span> <i class="fa fa-angle-left pull-right"></i></a>
           <ul class="treeview-menu">
              <li class="{{ Menu::activeMenu('calendario/riepilogo') }}"><a href="{{ url('admin/calendario') }}"><i class="fa fa-circle-o"></i> Riepilogo</a></li>
              <li class="{{ Menu::activeMenu('calendario/mostra') }}"><a href="{{ url('admin/calendario/mostra') }}"><i class="fa fa-circle-o"></i> Mostra Tutto</a></li>
              <li class="{{ Menu::activeMenu('calendario/genera') }}"><a href="{{ url('admin/calendario/genera') }}"><i class="fa fa-circle-o"></i> Genera</a></li>
           </ul>
        </li>

        <li class="treeview {{ Menu::activeMenu('moduli') }} {{ Menu::activeMenu('config') }}">
          <a href="#"><i class="fa fa-gear"></i> <span>Impostazioni</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li class="{{ Menu::activeMenu('moduli') }}"><a href="{{ url('admin/moduli') }}"><i class="fa fa-circle-o"></i> Moduli</a></li>
            <li class="{{ Menu::activeMenu('config/groups') }}"><a href="{{ url('admin/config/groups') }}"><i class="fa fa-circle-o"></i> Gruppi</a></li>
            <li><a href="#"><i class="fa fa-circle"></i>  Amministratori</a></li>
          </ul>
        </li>

        <li class="treeview {{ Menu::activeMenu('import') }} {{ Menu::activeMenu('utility') }}">
          <a href="#"><i class="fa fa-wrench"></i> <span>Utilità</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li class="{{ Menu::activeMenu('import') }}"><a href="{{ url('admin/import') }}"><i class="fa fa-circle-o"></i> Importa</a></li>
            <li><a href="#"><i class="fa fa-circle"></i> Esporta</a></li>
            <li class="{{ Menu::activeMenu('utility/backup') }}"><a href="{{ url('admin/utility/backup') }}"><i class="fa fa-circle-o"></i> Backup</a></li>
            <li class="{{ Menu::activeMenu('utility/database') }}"><a href="{{ url('admin/utility/database') }}"><i class="fa fa-circle-o"></i> Database</a></li>
          </ul>
        </li>

        <li class="header">&nbsp;</li>
        <li><a href="{{ url('auth/logout') }}"><i class="fa fa-unlock fa-fw text-red"></i> Esci</a></li>

      @else

        <li class="header">MENU</li>
        <li class="{{ Menu::activeMenu('user') }} {{ Menu::activeMenu('/') }}"><a href="{{ url('user') }}"><span>Home</span></a></li>
        <li class="{{ Menu::activeMenu('user/formazione') }}"><a href="{{ url('user/formazione') }}"><span>Formazione</span></a></li>
        <li class="{{ Menu::activeMenu('user/classifica') }} "><a href="{{ url('user/classifica') }}"><span>Classifica</span></a></li>
        <li class="{{ Menu::activeMenu('user/calendario') }}"><a href="{{ url('user/calendario') }}"><span>Calendario</span></a></li>
        <li class="{{ Menu::activeMenu('user/rosa') }}"><a href="{{ url('user/rosa') }}"><span>Rosa</span></a></li>
        <li class="header">&nbsp;</li>
        <li><a href="{{ url('auth/logout') }}"><i class="fa fa-unlock fa-fw text-red"></i> Esci</a></li>


      @endif

  </ul><!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->