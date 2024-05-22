@extends('layouts.app')

@section('content')
<div class="content-body">
            <!-- row -->
			<div class="container-fluid">
			    @if (session('success'))
			    <div class="alert alert-primary alert-dismissible fade show">
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
									<strong>Success!</strong> {{ session('success') }}
									<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
				</div>
				@endif
				@if (session('error'))
			   <div class="alert alert-danger alert-dismissible fade show">
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
									<strong>Error!</strong> {{ session('error') }}
									<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
								</div>
				@endif
								
				<div class="form-head d-flex mb-0 mb-lg-4 align-items-start">
					<div class="mr-auto d-none d-lg-block">
						<h2 class="text-black font-w600 mb-1">{{ __('Dashboard') }}</h2>
						<p class="mb-0">{{ __('Welcome to Escard Mobile Application Dashboard') }}</p>
					</div>
					<div class="d-none d-lg-flex align-items-center">
						<div class="text-right">
							<h3 class="fs-20 text-black mb-0">{{date('H:i')}}</h3>
							<span class="fs-14">{{date('Y-m-d')}}</span>
						</div>
						<a class="ml-4 text-black p-3 rounded border text-center width60" href="#">
							<i class="las la-cog scale5"></i>
						</a>
					</div>
				</div>
                <div class="row">
					<div class="col-lg-8 col-xxl-12">
						<div class="row">
							<div class="col-lg-4 col-sm-4">
								<div class="card widget-stat ">
									<div class="card-body p-4">
										<div class="media align-items-center">
											<div class="media-body">
												<p class="fs-18 mb-2 wspace-no">{{ __('Total Companies') }}</p>
												<h1 class="fs-36 font-w600 text-black mb-0">{{$companies}}</h1>
											</div>
											<span class="ml-3 bg-primary text-white">
												<i class="flaticon-381-promotion"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-4">
								<div class="card widget-stat">
									<div class="card-body p-4">
										<div class="media align-items-center">
											<div class="media-body">
												<p class="fs-18 mb-2 wspace-no">{{ __('Total Users') }}</p>
												<h1 class="fs-36 font-w600 d-flex align-items-center text-black mb-0">{{$users}}</h1>
											</div>
											<span class="ml-3 bg-warning text-white">
												<i class="flaticon-381-user-7"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4 col-sm-4">
								<div class="card widget-stat">
									<div class="card-body p-4">
										<div class="media align-items-center">
											<div class="media-body">
												<p class="fs-18 mb-2 wspace-no">{{ __('Total Active Users') }}</p>
												<h1 class="fs-36 font-w600 d-flex align-items-center text-black mb-0">{{$active_users}}</h1>
											</div>
											<span class="ml-3 bg-success text-white">
												<i class="flaticon-381-user-7"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
						
						</div>
					</div>
				
				</div>
            </div>
        </div>
@endsection
