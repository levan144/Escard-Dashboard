<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name', 'Dashboard') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{env('APP_URL')}}/assets/images/favicon.png">
    <link href="{{env('APP_URL')}}/assets/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{env('APP_URL')}}/assets/vendor/chartist/css/chartist.min.css">
    <link href="{{env('APP_URL')}}/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{env('APP_URL')}}/assets/css/style.css" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="{{env('APP_URL')}}/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{env('APP_URL')}}/assets/vendor/summernote/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">-->

    


</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/" class="brand-logo">
                <img class="logo-abbr" src="https://escard.ge/wp-content/uploads/2022/06/logo.svg" alt="">
                <img class="logo-compact" src="https://escard.ge/wp-content/uploads/2022/06/logo.svg" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
	
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown show">
                                <div class="dropdown-menu p-0 m-0 show">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search Here" aria-label="Search">
                                    </form>
                                </div>
								<span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M23.7871 22.7761L17.9548 16.9437C19.5193 15.145 20.4665 12.7982 20.4665 10.2333C20.4665 4.58714 15.8741 0 10.2333 0C4.58714 0 0 4.59246 0 10.2333C0 15.8741 4.59246 20.4665 10.2333 20.4665C12.7982 20.4665 15.145 19.5193 16.9437 17.9548L22.7761 23.7871C22.9144 23.9255 23.1007 24 23.2816 24C23.4625 24 23.6488 23.9308 23.7871 23.7871C24.0639 23.5104 24.0639 23.0528 23.7871 22.7761ZM1.43149 10.2333C1.43149 5.38004 5.38004 1.43681 10.2279 1.43681C15.0812 1.43681 19.0244 5.38537 19.0244 10.2333C19.0244 15.0812 15.0812 19.035 10.2279 19.035C5.38004 19.035 1.43149 15.0865 1.43149 10.2333Z" fill="#A4A4A4"/></svg>
                                </span>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                        
                             <li class="nav-item dropdown d-none d-xl-flex">
                                <a class="btn btn-primary" href="{{route('companies.new')}}">+ New Company</a>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
									<div class="header-info">
										<span>{{Auth::user()->name}}</span>
									</div>
                                    <img src="{{env('APP_URL')}}/assets/images/profile/pic1.jpg" width="20" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    
                                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">{{ __('Logout') }} </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
							
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">{{ __('Dashboard') }}</span>
						</a>
                        <ul aria-expanded="false">
							<li><a href="{{route('home')}}">{{ __('Dashboard') }}</a></li>
							<li><a href="{{route('settings')}}">{{ __('Settings') }}</a></li>
						</ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Users</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">{{ __('Companies') }}</a>
                                <ul aria-expanded="false">
                                    <li><a href="{{route('companies')}}">{{ __('All Companies') }}</a></li>
                                    <li><a href="{{route('companies.new')}}">{{ __('New Company') }}</a></li>
                                    <li><a href="{{route('categories')}}">{{ __('Categories') }}</a></li>
                                    
                                </ul>
                            </li>
                            
                               
							<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">{{ __('Users') }}</a>
                                <ul aria-expanded="false">
                                    <li><a href="{{route('users')}}">{{ __('All Users') }}</a></li>
                                    <li><a href="{{route('deleted_users')}}">{{ __('Deleted Users') }}</a></li>
									<li><a href="{{route('users.new')}}">{{ __('New User') }}</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">{{ __('Offers') }}</a>
                                <ul aria-expanded="false">
                                    <li><a href="{{route('offers')}}">{{ __('All Offers') }}</a></li>
									<li><a href="{{route('offers.new')}}">{{ __('New Offer') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('cards')}}">{{ __('Cards') }}</a></li>
                        </ul>
                    </li>
                    
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-promotion"></i>
							<span class="nav-text">Messages</span>
						</a>
                        <ul aria-expanded="false">
                            <!--<li><a href="{{route('messages')}}">All Messages</a></li>-->
                            <li><a href="{{route('messages.new')}}">Send Message</a></li>
                            
                        </ul>
                    </li>
                    
                  
                </ul>
				<div class="copyright">
					<p><strong> Dashboard</strong><br/>© All Rights Reserved</p>
					<p>By Levan Javakhishvili</p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
	
		<!--**********************************
            Content body start
        ***********************************-->
        @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © &amp; Developed by <a href="https://javal.ge/" target="_blank">Levan Javakhishvili</a> 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{env('APP_URL')}}/assets/vendor/global/global.min.js"></script>
    <script>
    $( "#addNewSectionPage" ).click(function(e) {
        e.preventDefault();
        if(jQuery('.pageSectionTabs')){
            var tabs = jQuery('.pageSectionTabs .nav-link');
            var cloneTab = tabs.last().clone( true ).removeClass( "show" ).removeClass( "active" ).attr('data-index', (tabs.length + 1)).attr('href', '#page' + (tabs.length + 1)).text('Page #' + (tabs.length + 1) );
            var sections = jQuery('.pageSectionContents .pageSection');
            var cloneSection = sections.last().clone( true ).removeClass( "show" ).removeClass( "active" ).attr('id', 'page' + (tabs.length + 1));
            
            cloneTab.appendTo( ".pageSectionTabs" );
            cloneSection.appendTo( ".pageSectionContents" );
            var inputs = jQuery('#' + 'page' + (tabs.length + 1) + ' input').val("");
            var inputs = jQuery('#' + 'page' + (tabs.length + 1) + ' input .description').attr("name", 'welcome_screens['+ (tabs.length + 1) +'][text]');
        }
    });
    
    
    if(jQuery('input[type=radio][name=send_to]')){
        jQuery('input[type=radio][name=send_to]').change(function() {
            if (this.value != 1) {
                jQuery('#to-company, #promo-input').show();
                jQuery('#to-custom').hide();
            } else {
                jQuery('#to-company, #promo-input').hide();
                jQuery('#to-custom').show();
            }
        });
    }
    if(jQuery("#repeater")){
    jQuery(function(){

  jQuery("#repeater").createRepeater();
jQuery("#repeater2").createRepeater();
});
    }
    </script>
	<script src="{{env('APP_URL')}}/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<!--<script src="/assets/vendor/chart.js/Chart.bundle.min.js"></script>-->
    <script src="{{env('APP_URL')}}/assets/js/custom.min.js"></script>
	<script src="{{env('APP_URL')}}/assets/js/deznav-init.js"></script>
	
	<!-- Counter Up -->
    <script src="{{env('APP_URL')}}/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="{{env('APP_URL')}}/assets/vendor/jquery.counterup/jquery.counterup.min.js"></script>	
		
	<!-- Apex Chart -->
	<!--<script src="/assets/vendor/apexchart/apexchart.js"></script>	-->
	
	<!-- Chart piety plugin files -->
	<script src="{{env('APP_URL')}}/assets/vendor/peity/jquery.peity.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{env('APP_URL')}}/assets/js/dashboard/dashboard-1.js"></script>
	<!-- Datatable -->
    <script src="{{env('APP_URL')}}/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/2.0.2/js/dataTables.searchPanes.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/2.0.2/js/searchPanes.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/staterestore/1.1.1/js/dataTables.stateRestore.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/staterestore/1.1.1/js/stateRestore.bootstrap5.min.js"></script>
    <script src="{{env('APP_URL')}}/assets/js/plugins-init/datatables.init.js?v=22"></script>
    
	<script src="{{env('APP_URL')}}/assets/vendor/summernote/js/summernote.min.js"></script>
	 <!-- Summernote init -->
    <script src="{{env('APP_URL')}}/assets/js/plugins-init/summernote-init.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{env('APP_URL')}}/assets/js/repeater.js" type="text/javascript"></script>
    <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
  <script>
   function addRemoveButton(fieldset) {
    fieldset.append('<button type="button" class="remove btn btn-sm btn-danger">Remove</button>');
  }
  // Add remove button to initial fieldset
  $('.repeater fieldset').each(function() {
    addRemoveButton($(this));
  });
  
      $('.repeater').on('click', '.button', function(e) {
    e.preventDefault();

    var $this = $(this),
        $repeater = $this.closest('.repeater').find('fieldset'),
        count = $repeater.length,
        $clone = $repeater.first().clone();

    $clone.find('[id]').each(function() {
        this.id = this.id + '_' + count;
    });

    $clone.find('[name]').each(function() {
        this.name = $(this).data('namestart')  + '[' + count + ']' + $(this).data('name');
    });

    $clone.find('label').each(function() {
        var $this = $(this);
        $this.attr('for', $this.attr('for') + '_' + count);
    });
    $clone.find('.remove').remove();
      // Add a remove button to the cloned fieldset
    addRemoveButton($clone);


    $clone.insertBefore($this);
});
 // Function to handle remove button clicks
  $('body').on('click', '.remove', function() {
    $(this).parent().remove();
  });
  </script>
  
 
</body>
</html>