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
						<h2 class="text-black font-w600 mb-1">{{ __('Edit User') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-default " name="name" placeholder="{{ __('Firstname') }}" value="{{$user->name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-default " name="lastname" placeholder="{{ __('Lastname') }}" value="{{$user->lastname}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-default " name="sid" placeholder="{{ __('Personal ID') }}" value="{{$user->sid}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="tel" class="form-control input-default " name="phone" placeholder="{{ __('Phone Number') }}" value="{{$user->phone}}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control input-default " name="email" placeholder="{{ __('Email') }}" value="{{$user->email}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="password" class="form-control input-default " name="password" placeholder="{{ __('Password') }}" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="company_id" id="sel1">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{$company->id}}" @if($user->company_id == $company->id) selected @endif>{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <fieldset class="form-group">
                                                    <div class="row">
                                                        <label class="col-form-label col-sm-3 pt-0">Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="status" value="1" @if(!$user->deleted_at) checked="" @endif>
                                                                    Active
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="status" value="0" @if($user->deleted_at) checked="" @endif>
                                                                
                                                                    Disabled
                                                                </label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="text-left mt-4 mb-5">
                                                    <button class="btn btn-primary btn-sl-sm mr-2" type="submit"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Submit</button>
                                                    <a class="btn  btn-primary" href="{{route('password.generate', $user->id)}}">Generate Password & Send Email</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
				
				</div>
            </div>
        </div>
@endsection
