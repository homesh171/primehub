@php

$aid = session()->get('SUPERADMIN_ID');

$data = DB::table('ph_super_admins')->where('id',$aid)->first();
$role = App\Models\role::where('id',$data->role)->first();

@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
      <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
    <title>@yield('page_title')</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/animate.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/style.css')}}">
     
    <link id="color" rel="stylesheet" href="{{url('backend/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/jquery.fancybox.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
   <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/style1.css')}}">
  <style>
       .page-wrapper .page-header .header-wrapper .nav-right .profile-dropdown{
          /*left:-77px !important;*/
      }
      
      
      .page-wrapper .page-header .header-wrapper{
          padding:15px 30px !important;
      }
      
      
      .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .logo-wrapper, .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .logo-icon-wrapper{
          padding: 10px 30px !important;
          background:#fff !important;
      }
      
                   .back-btn{
   position: absolute !important;
    right: 20px !important;
    top: 15px !important;
    
    }
    
    .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links {
    height: calc(100vh) !important;

}

.page-wrapper.compact-wrapper .page-body-wrapper .page-body {
    min-height: calc(100vh);
    margin-top: 70px;
    margin-left: 265px;
}


.page-wrapper .page-header .header-wrapper .nav-right .profile-dropdown {
    width: auto !important;
    top: 57px;
    left: -12px;
    padding: 0 10px;
}
  </style>
  </head>
  <body > 

    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
 <!-- Page Header Start-->
      <div class="page-header">
        <div class="header-wrapper row m-0">
          <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
              <div class="Typeahead Typeahead--twitterUsers">
          
                <div class="Typeahead-menu"></div>
              </div>
            </div>
          </form>
          <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="{{route('superadmin.index')}}"><img class="img-fluid" src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
          </div>
   
          <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">


          <li>
                <a href="{{url('reset')}}">
               <i class="fa fa-spin fa-refresh"></i>
               </a>
              </li>
     
              <!--<li class="onhover-dropdown">-->
              <!--  <div class="notification-box">-->
              <!--    <svg>-->
              <!--      <use href="{{url('backend/assets/svg/icon-sprite.svg#notification')}}"></use>-->
              <!--    </svg><span class="badge rounded-pill badge-secondary">4 </span>-->
              <!--  </div>-->
                <!--<div class="onhover-show-div notification-dropdown">-->
                <!--  <h6 class="f-18 mb-0 dropdown-title">Notitications                               </h6>-->
                <!--  <ul>-->
                      
                <!--    <li class="b-l-primary border-4">-->
                <!--      <p>Delivery processing <span class="font-danger">10 min.</span></p>-->
                <!--    </li>-->
            
                <!--    <li><a class="f-w-700" href="#">Check all</a></li>-->
                <!--  </ul>-->
                <!--</div>-->
              <!--</li>-->
              <li class="profile-nav onhover-dropdown pe-0 py-0">
                <div class="media profile-media"><img class="b-r-10" src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" alt="" width="40px" style="object-fit: contain;
    aspect-ratio: 1 / 1;">
                  <div class="media-body"><span style="text-transform: capitalize;">{{$data->username}}</span>
                    <p class="mb-0" style="text-transform: capitalize;">{{$role->role}} <i class="middle fa fa-angle-down"></i></p>
                  </div>
                </div>
                <ul class="profile-dropdown onhover-show-div">
                 <li><a href="{{route('superadmin.change-password')}}"><i data-feather="lock"></i><span>Change Password</span></a></li>
                  <li><a href="{{route('superadmin.logout')}}"><i data-feather="log-in"> </i><span>Log Out</span></a></li>
                </ul>
              </li>
            </ul>
          </div>
          <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">Dummy</div>
            </div>
            </div>
          </script>
          <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
        </div>
      </div>
      <!-- Page Header Ends       -->                 