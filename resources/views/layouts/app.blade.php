<!DOCTYPE html>
<html lang="it">

<head>
    @include('inc.head')
</head>

<body class="skin-green">

    <div class="wrapper">

        <header class="main-header">
            @include('inc.header')
        </header>



        <aside class="main-sidebar">
            @include('inc.sidebar')
        </aside>



        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('page-header')
            </section>

            <!-- Main content -->
            <section class="content">

                @if (Session::has('message'))
                    <div class="row">
                      <div class="col-md-12">

                          <?php
                            if( Session::get('messageType') ):
                                $messageType = Session::get('messageType');
                            else:
                                $messageType = 'info';
                            endif;
                          ?>

                          <div class="callout callout-{{ $messageType }}">
                              <!-- <h4>info callout!</h4> -->
                              <p>{{ Session::get('message') }}</p>
                          </div>

                      </div>
                    </div>
                @endif

                @yield('page-content')
            </section>

        </div>


        <div id="cb-modal-sm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="smModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header hide">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Operazione Completata
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <footer class="main-footer">
            @include('inc.footer')
        </footer>


    </div>

	<!-- Scripts -->
	@include('inc.scripts')

</body>
</html>
