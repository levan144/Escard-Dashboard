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
						<h2 class="text-black font-w600 mb-1">{{ __('All Categories') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-xl-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title">Add Category</h5>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('categories.update', $category->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                                <div id="tabs" class="mb-4">
                                                    <ul>
                                                        <li><a href="#tabs-1">Georgian</a></li>
                                                        <li><a href="#tabs-2">English</a></li>
                                                    </ul>
                                                    <div id="tabs-1" >
                                                        <div class="form-group">  
                                                            <input type="text" class="form-control input-default " name="name[ka]" value="{{$category->translations['name']['ka'] ?? ''}}" placeholder="{{ __('Name (KA)') }}" required>
                                                        </div>
                                                    </div>
                                                    <div id="tabs-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="name[en]" value="{{$category->translations['name']['en'] ?? ''}}" placeholder="{{ __('Name (EN)') }}" required>
                                                        </div>
                                                </div>
                                                </div>
                                        <!-- <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{$category->name}}" class="form-control input-default ">
                                        </div> -->
                                        <div class="form-group">
                                            <label>Color Code</label>
                                            <input type="color" name="color" value="{{$category->color}}" class="form-control input-rounded">
                                        </div>
                                        <div class="form-group">
                                            <img src="{{$category->icon}}" width="50" class="d-block">
                                            <label>Icon</label>
                                            <input type="file" name="icon" class="form-control input-rounded">
                                        </div>
                                        <div class="form-group">
                                            <img src="{{$category->icon_hover}}" width="50" class="d-block">
                                            <label>Icon Hover</label>
                                            <input type="file" name="icon_hover" class="form-control input-rounded">
                                        </div>
                                       
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sl-sm mr-2" type="submit"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title">Categories</h5>
                            </div>
                            <div class="card-body">
                               <div class="basic-list-group">
                                    <ul class="list-group">
                                        @foreach($categories as $category)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{$category->name}} <a href="{{route('categories.edit', $category->id)}}"><span class="badge badge-primary badge-pill"><i class="fa fa-pencil"></i></span></a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
				
				</div>
            </div>
        </div>
@endsection
