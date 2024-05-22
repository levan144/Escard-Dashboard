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
						<h2 class="text-black font-w600 mb-1">{{ __('Add New Company') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                
                                    <form action="{{route('companies.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div id="tabs" class="mb-4">
                                                    <ul>
                                                        <li><a href="#tabs-1">Georgian</a></li>
                                                        <li><a href="#tabs-2">English</a></li>
                                                    </ul>
                                                    <div id="tabs-1" >
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="name[ka]" placeholder="{{ __('Company name (KA)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="working_hours[ka]" placeholder="{{ __('Working Hours (KA)') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="address[ka]" placeholder="{{ __('Address (KA)') }}">
                                                        </div>
                                                    </div>
                                                    <div id="tabs-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="name[en]" placeholder="{{ __('Company name (EN)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="working_hours[en]" placeholder="{{ __('Working Hours (EN)') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="address[en]" placeholder="{{ __('Address (EN)') }}">
                                                        </div>                                                    </div>
                                                   
                                                </div>
                                                
                                                
                                               
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-default " name="phone" placeholder="{{ __('Phone Number') }}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-default " name="website" placeholder="{{ __('Website') }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select class="form-control" name="category_id" id="sel1">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->translations['name']['ka']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" class="form-control input-default" name="featured_image" placeholder="{{ __('Featured Image') }}" required>
                                                </div>
                                                <fieldset class="form-group">
                                                    <div class="row">
                                                        <label class="col-form-label col-sm-3 pt-0">Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="status" value="1" checked="">
                                                                    Active
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="status" value="0">
                                                                
                                                                    Disabled
                                                                </label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                
                                                <div class="text-left mt-4 mb-5">
                                                    <button class="btn btn-primary btn-sl-sm mr-2" type="submit"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Submit</button>
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
