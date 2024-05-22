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
						<h2 class="text-black font-w600 mb-1">{{ __('All Cards') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-xl-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title">Add Card</h5>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('cards.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Color Code</label>
                                            <input type="color" name="color" class="form-control input-rounded">
                                        </div>
                                        <div class="form-group">
                                            <label>Featured Image</label>
                                            <input type="file" name="featured_image" class="form-control input-rounded">
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
                                <h5 class="card-title">Cards</h5>
                            </div>
                            <div class="card-body">
                               <div class="basic-list-group">
                                    <ul class="list-group">
                                        @foreach($cards as $card)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <i class="fa fa-circle mr-1" style="color: {{$card->color}}"></i> <a href="{{route('cards.edit', $card->id)}}"><span class="badge badge-primary badge-pill"><i class="fa fa-pencil"></i></span></a>
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
