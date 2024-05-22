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
						<h2 class="text-black font-w600 mb-1">{{ __('General Settings') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">General page</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('settings.update', $lang)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="type" value="general">
                                        <div class="form-group">
                                            <label>Website Logo</label>
                                            <input type="file" name="logo" class="form-control input-default " >
                                        </div>
                                        <div class="form-group">
                                            <label>Illustration</label>
                                            <input type="file" name="welcome_illustration" class="form-control input-default " >
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Register and Card Screen</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('settings.update', $lang)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="type" value="register_screens">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="register_screens[title]" class="form-control input-default " value="{{$register_screens['title'] ?? ''}}" placeholder="Title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <input type="text" name="register_screens[text]" class="form-control input-default " value="{{$register_screens['text'] ?? ''}}" placeholder="Text">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card Title</label>
                                                        <input type="text" name="register_screens[card_title]" class="form-control input-default " value="{{$register_screens['card_title'] ?? ''}}" placeholder="Card title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card Barcode</label>
                                                        <input type="file" name="barcode" class="form-control input-default " >
                                                    </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Welcome Screens</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="nav flex-column nav-pills mb-3 pageSectionTabs">
                                            @foreach($welcome_screens ?? [''] as $indexKey => $value)
                                                
                                                    <a href="#page{{$indexKey + 1}}" data-index="{{$indexKey + 1}}" data-toggle="pill" class="nav-link @if($indexKey == 0) show active @endif">Page #{{$indexKey + 1}}</a>

                                                
                                            @endforeach
                                            
                                            
                                        </div>
                                        <button class="btn-sm btn-secondary mt-3" id="addNewSectionPage">Add new Page</button>
                                    </div>
                                    <div class="col-xl-9">
                                        <form action="{{route('settings.update', $lang)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="welcome_screens">
                                            <div class="tab-content pageSectionContents">
                                                @foreach($welcome_screens ?? [1 => ''] as $indexKey => $value)
                                                    
                                                    <div id="page{{$indexKey + 1}}" class="tab-pane fade @if($indexKey == 0) active show @endif pageSection">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" name="welcome_screens[][title]" class="form-control input-default " value="{{$value['title']  ?? ''}}" placeholder="Title">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input type="text" name="welcome_screens[{{$indexKey}}][text]" class="form-control input-default description" value="{{$value['text']  ?? ''}}" placeholder="Text">
                                                        </div>
                                                    </div>
                                                   
                                                    
                                                @endforeach
                                                
                                               
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Homepage Screen</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="nav flex-column nav-pills mb-3">
                                            <a href="#general" data-toggle="pill" class="nav-link show active">General Slider</a>
                                            <a href="#popular" data-toggle="pill" class="nav-link">Popular Offers</a>
                                            <a href="#bigsale" data-toggle="pill" class="nav-link">Big Sale Offers</a>
                                            <a href="#special" data-toggle="pill" class="nav-link">Special Offers</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-9">
                                        <form action="{{route('settings.update', $lang)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="homepage">
                                            <div class="tab-content">
                                                <div id="general" class="tab-pane fade active show">
                                                    <div class="form-group">
                                                        <label>Choose Offers To Display</label>
                                                        <select multiple class="form-control" name="homepage[general_slider][]" id="sel2">
                                                            @foreach($offers as $offer)
                                                                <option value="{{$offer->id}}" @if(in_array($offer->id, $homepage_screens['general_slider'] ?? [])) selected @endif>{{$offer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                <div id="popular" class="tab-pane fade">
                                                    <div class="form-group">
                                                        <label>Choose Offers To Display</label>
                                                        <select multiple class="form-control" name="homepage[popular_offers][]" id="sel2">
                                                            @foreach($offers as $offer)
                                                                <option value="{{$offer->id}}" @if(in_array($offer->id, $homepage_screens['popular_offers'] ?? [])) selected @endif>{{$offer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="bigsale" class="tab-pane fade">
                                                    <div class="form-group">
                                                        <label>Choose Offers To Display</label>
                                                        <select multiple class="form-control" name="homepage[bigsale_offers][]" id="sel2">
                                                            @foreach($offers as $offer)
                                                                <option value="{{$offer->id}}" @if(in_array($offer->id, $homepage_screens['bigsale_offers'] ?? [])) selected @endif>{{$offer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="special" class="tab-pane fade">
                                                    <div class="form-group">
                                                        <label>Choose Offers To Display</label>
                                                        <select multiple class="form-control" name="homepage[special_offers][]" id="sel2">
                                                            @foreach($offers as $offer)
                                                                <option value="{{$offer->id}}" @if(in_array($offer->id, $homepage_screens['special_offers'] ?? [])) selected @endif>{{$offer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				
				</div>
            </div>
        </div>
@endsection