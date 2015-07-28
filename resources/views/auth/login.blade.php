@extends('layouts.app_clean')

@section('page-content')
<div class="container">


    <!-- /.row -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3">


            <h1 class="page-header">
                <i class="fa fa-futbol-o fa-fw"></i> Talent's Manager
                <small>v.{{ \Config::get('Silent.version')  }}</small>
            </h1>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-lock"></i> Accedi all'Area Riservata</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Ricordami
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in fa-fw"></i> Login</button>

                                <small style="display: block;
                                            margin-top: 15px;
                                            padding-top: 15px;
                                            border-top: 1px solid #f3e5f5;
                                            text-align: right">
                                    <!-- <a href="{{ url('/password/email') }}"><i class="fa fa-angle-right fa-fw"></i> Password dimenticata?</a> -->
                                </small>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
