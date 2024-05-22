@extends('layouts.app')

@section('content')
<div class="content-body offersForm">
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
						<h2 class="text-black font-w600 mb-1">{{ __('Add New Offer') }}</h2>
					</div>
					
				</div>
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Georgian
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('offers.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="tabs" class="mb-4">
                                                    <ul>
                                                        <li><a href="#tabs-1">Georgian</a></li>
                                                        <li><a href="#tabs-2">English</a></li>
                                                    </ul>
                                                    <div id="tabs-1" >
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="name[ka]" placeholder="{{ __('Name (KA)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="subtitle[ka]" placeholder="{{ __('Subtitle (KA)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="description[ka]" placeholder="{{ __('Description (KA)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="sale_text[ka]" placeholder="{{ __('Sale Text (KA)') }}">
                                                        </div>
                                                        
                                                    <div class="repeater">
    
   
                                                            <div data-repeatable>
                                                                <h4>Benefits</h4>
                                                               
                                                                <fieldset>
                                                                    <label for="field"></label>
                                                                    <input type="text" class="form-control input-default" name="benefits[ka][0][title]" data-nameStart="benefits[ka]" data-name="[title]" placeholder="Enter name" id="field"><br>
                                                                    <input type="text" class="form-control input-default" name="benefits[ka][0][description]" data-nameStart="benefits[ka]" data-name="[description]" placeholder="Enter description" id="field">
                                                                    <div class="form-group row"><!--Icon-->
                                                                                                                      <label for="inputIcon" class="col-lg-12 control-label">Icon</label>
                                                                                                                      <div class="col-lg-4">
                                                                                                                     <label >  <input type="radio" @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-sr-gift.png') === $benefit['icon']) checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-sr-gift.png" data-nameStart="benefits[ka]"  data-name="[icon]"  name="benefits[ka][0][icon]"> <img src="/benefit_icons/fi-sr-gift.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                       <div class="col-lg-4">
                                                                                                                      <label >  <input type="radio" @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-br-hastag.png') === $benefit['icon'] ?? '') checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-br-hastag.png" data-nameStart="benefits[ka]" data-name="[icon]"  name="benefits[ka][0][icon]"><img src="/benefit_icons/fi-br-hastag.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                       <div class="col-lg-4">
                                                                                                                       <label > <input type="radio"  @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-br-ticket.png') === $benefit['icon'] ?? '') checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-br-ticket.png" data-nameStart="benefits[ka]"   data-name="[icon]" name="benefits[ka][0][icon]"><img src="/benefit_icons/fi-br-ticket.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                    </div><!--Icon-->
                                                                                                                    <div class="form-group">
                                                                                                                        <label for="inputColor" class="col-lg-12 control-label">Color</label>
                                                                                                                          <div class="col-lg-12">
                                                                                                                          <input type="color" class="form-control" id="inputColor" placeholder="Color" value="#788E76" name="benefits[ka][0][color]" data-skip-name="false" data-nameStart="benefits[ka]" data-name="[color]" >
                                                                                                                          </div>
                                                                                                                    </div>
                                                                                                                     <div class="form-group">
                                                                                                                        <label for="inputColor" class="col-lg-12 control-label">URL</label>
                                                                                                                          <div class="col-lg-12">
                                                                                                                          <input type="url" class="form-control" id="inputColor" placeholder="URL" value="" name="benefits[ka][0][url]" data-skip-name="false" data-nameStart="benefits[ka]" data-name="[url]" >
                                                                                                                          </div>
                                                                                                                    </div>
                                                                                                                    <!--<button type="button " class="remove btn btn-sm btn-danger">Remove</button>-->
                                                                </fieldset>
                                                                
       </div>
                                                           
                                                            <a href="#" class="button btn btn-sm btn-primary mt-4">Add Fields</a>
                                                        </div>
                                                        
                                                    </div>
                                                    <div id="tabs-2">
                                                    <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="name[en]" placeholder="{{ __('Name (EN)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="subtitle[en]" placeholder="{{ __('Subtitle (EN)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="description[en]" placeholder="{{ __('Description (EN)') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control input-default " name="sale_text[en]" placeholder="{{ __('Sale Text (EN)') }}">
                                                        </div>
                                                        
                                                        <div class="repeater">
    
   
                                                            <div data-repeatable>
                                                                <h4>Benefits</h4>
                                                               
                                                                <fieldset>
                                                                    <label for="field"></label>
                                                                    <input type="text" class="form-control input-default" name="benefits[en][0][title]" data-nameStart="benefits[en]" data-name="[title]" placeholder="Enter name" id="field"><br>
                                                                    <input type="text" class="form-control input-default" name="benefits[en][0][description]" data-nameStart="benefits[en]" data-name="[description]" placeholder="Enter description" id="field">
                                                                    <div class="form-group row"><!--Icon-->
                                                                                                                      <label for="inputIcon" class="col-lg-12 control-label">Icon</label>
                                                                                                                      <div class="col-lg-4">
                                                                                                                     <label >  <input type="radio" @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-sr-gift.png') === $benefit['icon']) checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-sr-gift.png" data-nameStart="benefits[en]"  data-name="[icon]"  name="benefits[en][0][icon]"> <img src="/benefit_icons/fi-sr-gift.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                       <div class="col-lg-4">
                                                                                                                      <label >  <input type="radio" @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-br-hastag.png') === $benefit['icon'] ?? '') checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-br-hastag.png" data-nameStart="benefits[en]" data-name="[icon]"  name="benefits[en][0][icon]"><img src="/benefit_icons/fi-br-hastag.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                       <div class="col-lg-4">
                                                                                                                       <label > <input type="radio"  @if(isset($benefit['icon']) && (request()->getSchemeAndHttpHost() . '/benefit_icons/fi-br-ticket.png') === $benefit['icon'] ?? '') checked @endif value="{{request()->getSchemeAndHttpHost()}}/benefit_icons/fi-br-ticket.png" data-nameStart="benefits[en]"   data-name="[icon]" name="benefits[en][0][icon]"><img src="/benefit_icons/fi-br-ticket.svg" style="filter:invert(1)"></label> 
                                                                                                                      </div>
                                                                                                                    </div><!--Icon-->
                                                                                                                    <div class="form-group">
                                                                                                                        <label for="inputColor" class="col-lg-12 control-label">Color</label>
                                                                                                                          <div class="col-lg-12">
                                                                                                                          <input type="color" class="form-control" id="inputColor" placeholder="Color" value="#788E76" name="benefits[en][0][color]" data-skip-name="false" data-nameStart="benefits[en]" data-name="[color]" >
                                                                                                                          </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group">
                                                                                                                        <label for="inputColor" class="col-lg-12 control-label">URL</label>
                                                                                                                          <div class="col-lg-12">
                                                                                                                          <input type="url" class="form-control" id="inputColor" placeholder="URL"  name="benefits[en][0][url]" data-skip-name="false" data-nameStart="benefits[en]" data-name="[url]" >
                                                                                                                          </div>
                                                                                                                    </div>
                                                                                                                    <!--<button type="button " class="remove btn btn-sm btn-danger">Remove</button>-->
                                                                </fieldset>
                                                                
       </div>
                                                           
                                                            <a href="#" class="button btn btn-sm btn-primary mt-4">Add Fields</a>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                   
                                                </div>
                                                
                                                
                                                
                                                <div class="text-left mt-4 mb-5">
                                                    <button class="btn btn-primary btn-sl-sm mr-2" type="submit"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <select class="form-control" name="company_id" id="sel1">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{$company->id}}">{{$company->name}}</option>
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
