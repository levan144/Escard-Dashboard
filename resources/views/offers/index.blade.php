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
									<strong>Error!</strong> {{ session('success') }}
									<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
								</div>
				@endif
								
				<div class="form-head d-flex mb-0 mb-lg-4 align-items-start">
					<div class="mr-auto d-none d-lg-block">
						<h2 class="text-black font-w600 mb-1">{{ __('All Offers') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <!--<th></th>-->
                                                
                                                <th>Name</th>
                                                <th>Sale Text</th>
                                                <th>Company</th>
                                                <th>Creation Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($offers as $offer)
                                            <tr>
                                                <!--<td><img class="rounded-circle" width="35" src="{{$offer->featured_image}}" alt=""></td>-->
                                                
                                                <td>{{$offer->translations['name']['ka']  ?? ''}}</td>
                                                <td>{{$offer->translations['sale_text']['ka']  ?? ''}}</td>
                                                <td><a href="javascript:void(0);"><strong>{{$offer->getCompany->translations['name']['ka']  ?? ''}}</strong></a></td>
                                                <td><a href="javascript:void(0);"><strong>{{$offer->created_at}}</strong></a></td>
                                                <td>{{$offer->active ? 'Active' : 'Disabled'}}</td>
                                                <td>
													<div class="d-flex">
														<a href="{{route('offers.edit', $offer->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
														<a href="{{route('offers.delete', $offer->id)}}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
													</div>												
												</td>												
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				
				</div>
            </div>
        </div>
@endsection
