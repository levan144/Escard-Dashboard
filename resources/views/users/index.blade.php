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
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
									<strong>Error!</strong> {{ session('error') }}
									<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
				</div>
				@endif
				@if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Error!</strong>
                        <ul>
                             @foreach (session()->get('errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                        </ul>
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>
                @endif
    
			    <div class="row">
			        <div class=" card col-12 p-4">
			            <h3 class="mb-4">Delete Users By Company</h3>
			            <form class="form-inline" method="POST" action="{{route('users.massDelete')}}">
			                @csrf
                          <div class="form-group mb-2">
                            <label for="staticEmail2" class="sr-only">Company</label>
                            <select name="company_id">
                                <option value="" selected>Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2" class="sr-only">Password</label>
                            <input type="password" class="form-control" name="password" id="inputPassword2" placeholder="Password">
                          </div>
                          <button type="submit" class="btn btn-primary mb-2">Confirm identity & Delete Users</button>
                        </form>
			        </div>
			    </div>
								
				<div class="form-head d-flex mb-0 mb-lg-4 align-items-start">
					<div class="mr-auto d-none d-lg-block">
						<h2 class="text-black font-w600 mb-1">{{ __('All Users') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="exampleUser" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fullname</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Company</th>
                                                <th>Card</th>
                                                <th>Status</th>
                                                <th>Reg.Date</th>
                                                <th>Active Until</th>
                                                <th>Payment in</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->lastname}} {{$user->name}}</td>
                                                <td>{{$user->id == 1 ? 'Admin' : 'User'}}</td>
                                                <td>{{$user->email}}</td>
                                                <td><strong>{{$user->phone}}</strong></td>
                                                <td><strong>{{$user->getCompany->name ?? 'Individual'}}</strong></td>
                                                <td class="text-center"><strong><span class="badge badge-rounded" style="background-color: {{$user->getCard->color ?? ''}}"> </span></strong></td>
                                                <td>{!! !$user->deleted_at && (($user->getCompany && $user->getCompany->active) || (!$user->getCompany)) ? '<span class="badge badge-rounded badge-primary">Active</span>' : '<span class="badge badge-rounded badge-danger">Disabled</span>' !!}</td>
                                                <td>{{$user->created_at}}</td>
                                                <td>{{$user->active_until}}</td>
                                                <td>{{$user->active_until_days}}</td>
                                                <td>
													<div class="d-flex">
														<a href="{{route('users.edit', $user->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
														@if(!$user->deleted_at)<a href="{{route('users.destroy', $user->id)}}" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>@endif
														@if($user->deleted_at)<a href="{{route('users.enable', $user->id)}}" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>@endif

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
