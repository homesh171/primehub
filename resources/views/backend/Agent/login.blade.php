<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
    <title>Login</title>
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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{url('backend/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/assets/css/responsive.css')}}">
    	
	<style>
	
	.image-h{
	height:480px;
	}
	
	.login-footer {
		color:#ffffff;
		background:#ea3d5b;
		padding:10px 0;
	}
	
	 .login-footer p {
		margin: 0;
		font-size: 16px;
	}
	
	 .login-footer .cutomerNo {
		margin: 0;
    font-size: 16px;
    text-align: center;
	}
	
	.login-footer .cutomerNo a{
		color:white !important;
	}
	
	.login-footer .footer-social-icons{
		 text-align: right;
	}
	
	.login-footer .footer-social-icons .social-icons{
		 display:flex;
		 gap:20px;
		 justify-content:end;
	}
	
	.login-footer .footer-social-icons .social-icons a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    transition: .5s;
    background-color: #ffffff00;
    border: 1px solid #fff;
    width: 30px;
    display: inline-block;
    text-align: center;
    height: 30px;
    line-height: 28px;
}

	@media(max-width:768px){
		.login-footer .footer-social-icons{
			justify-content:center !important;
			display:flex;
		}
		
		.login-footer p{
		    text-align:center;
		}
	}

.login-form-control {
    border: 1px solid #ffffff !important;
    background-color: #fffefe00 !important;
}

.login-submit-btn{
	background-color: #ea3d5b !important;
    border-color: #ea3d5b !important;
	color:white;
}

.login-submit-btn:hover{
	color:white;
}

.login-create-link{
	color:#ea3d5b;
}

.login-create-link:hover{
	color:#ea3d5b;
}

.login-header{
	background:#ea3d5b;
}

.login-header-logo{
 width: 100px;
    height: auto;
    object-fit: fill;
    background: white;
    padding: 8px;
    border-radius: 10px;
}

.login-form{
 
  height:100%;
padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 37px rgba(8, 21, 66, 0.05);
    margin: 0 auto;
    background-color: #fff;
      background: url({{url('backend/assets/images/page-bg.jpg')}}) no-repeat center;

}


.login_right_panel a{
color:white;
}

.login_right_panel a i{
	background:white;
	padding:12px;
	display:inline-block;
	color:#ea3d5b;
	font-size:15px;
	border-radius:50%;
	margin-right:5px;
}

.login-section{

     border: 1px solid white;
}



.theme-form{color:#fff;}

.checkbox input[type=checkbox]:checked + label::before{
    color:black !important;
}
	</style>
  </head>
  <body>
       
<section class="login-header">
		<div class="container-fluid">
			<div class="row py-1">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="d-flex align-items-center justify-content-between">
						<img src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" class="login-header-logo">	
						<div>
							<div class="login_right_panel">
								<a href="tel:{{$globalData->telephone}}">
                                <i class="fa fa-phone" aria-hidden="true"></i>{{$globalData->telephone}}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
  
    <!-- login page start-->
<section class="login-section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 px-0" style="background: #4a0a1a;">
    		<div id="demo" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="{{url('backend/assets/images/banner-prime.jpg')}}" class="w-100">
                </div>
                <div class="carousel-item">
                  <img src="{{url('backend/assets/images/banner_login.jpg')}}" class="w-100">
                </div>
              </div>
            </div>
		</div>
        <div class="col-lg-4 col-md-4 col-sm-12 px-0 full-landing-image">
              <div class="login-form w-100 py-4"> 
                <form class="theme-form" id="agentfrmLogin" method="post">
                     @csrf
                  <h4 class="mb-2">Sign in to account</h4>
                  <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class=" login-form-control form-control" type="email" required="" name="email" placeholder="Exmple@gmail.com">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class=" form-input position-relative">
                      <input class="login-form-control form-control" type="password" name="password" required="" placeholder="*********">
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox" required="">
                      <label class="" for="checkbox1" style="color:#fff;">I agree <a href="{{route('agent.Terms&Conditions')}}" style="color:#fff;">Terms and Conditions of primehubsofttechsolutions</a></label>
                    </div>
                    
                  </div>
                  <div class="form-group mt-2">
                       <a class="" href="{{route('agent.forgot-password')}}" style="color:#fff;"> Forgot password?</a>
                    <button class="btn login-submit-btn btn-block w-100 mt-3" type="submit">Sign in</button>
                    <div style="    margin-top: 7px; color:red;" id="login_msg"></div>
                  </div>
                 
                </form>
              </div>
        </div>
      </div>
    </div>
</section>

<section class="login-footer">
		<div class="container-fluid">
			<div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <p class="ng-binding">{{$globalData->copyright_details}}</p>
                    </div>
       
          <div class="col-lg-1 col-md-6 col-sm-12"> 
                        <div class="cutomerNo"><a href="https://primehubsofttechsolutions.com/privacy-police.php">Privacy Policy</a> </div>
                    </div>
                       <div class="col-lg-2 col-md-6 col-sm-12"> 
                        <div class="cutomerNo"><a href="https://primehubsofttechsolutions.com/terms-condition.php">Terms & Conditions</a> </div>
                    </div>
                       <div class="col-lg-2 col-md-6 col-sm-12"> 
                        <div class="cutomerNo"> <a href="https://primehubsofttechsolutions.com/refund-policy.php">Cancellation & Refund Policy</a> </div>
                    </div>
                    
                           <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="footer-social-icons">
                            <ul class="social-icons">
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="" target="_blank" class="facebook" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="" target="_blank" class="twitter" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="" target="_blank" class="youtube" data-original-title="Youtube"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="" target="_blank" class="linkedin" data-original-title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="h#" data-toggle="tooltip" data-placement="top" title="" target="_blank" class="instagram" data-original-title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#" target="_blank" data-toggle="tooltip" data-placement="top" title="" class="website" data-original-title="Website"><i class="fa fa-globe"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>
		</div>
	  </section>
      <!-- latest jquery-->
      <script src="{{url('backend/assets/js/jquery.min.js')}}"></script>
      <!-- Bootstrap js-->
      <script src="{{url('backend/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
      <!-- feather icon js-->
      <script src="{{url('backend/assets/js/icons/feather-icon/feather.min.js')}}"></script>
      <script src="{{url('backend/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="{{url('backend/assets/js/config.js')}}"></script>
      <!-- Plugins JS start-->
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="{{url('backend/assets/js/script.js')}}"></script>
          <script src="{{url('backend/assets/js/custom.js')}}" async></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.ripples/0.5.3/jquery.ripples.min.js"></script>
<script>
    $(".login-form").ripples({
  resolution: 300,
  perturbance: 0.009,
});
</script>
    </div>
  </body>
</html>