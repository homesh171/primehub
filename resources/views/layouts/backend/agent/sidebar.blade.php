@php

$id = Session('AGENT_ID');

$AEPSOnboarding = App\Models\AEPSOnboarding::where('user_id',$id)->first();
$aeps_2factor_register = App\Models\aeps_2factor_register::where('user_id',$id)->first();
$TxnMerchantAuthenticity = App\Models\TxnMerchantAuthenticity::where('user_id',$id)->first();
@endphp

<style>
 .sidelogo{
        width:64px;
    }


</style>
 <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" sidebar-layout="stroke-svg">
          <div>
            <div class="logo-wrapper"><a href="{{route('agent.index')}}"><img class="img-fluid for-light" width="64px" src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" alt=""></a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
              <!--<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>-->
            </div>
     
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn"><a href="{{route('agent.index')}}"></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
           
       <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('agent.index')}}">
                      <svg class="stroke-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#fill-home')}}"> </use>
                      </svg><span>Dashboard</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>

 
                      
                      
<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="icon-wallet me-3"></i>
<span>Wallet</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.wallet.addmoney')}}">Add To Wallet</a></li>
<li><a href="{{route('agent.wallet.transaction-history')}}">Transaction History</a></li>
</ul>
</li>


<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-cloud-download me-3"></i>
<span>Payout Request</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.wallet.moneyrequset')}}">Payout Request</a></li>
<li><a href="{{route('agent.wallet.payment_requset_history')}}">Payout Request History</a></li>
</ul>
</li>

                      
<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-sun-o me-3"></i>
<span>DMT</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.payout.beneficiaries')}}">DMT Transfer</a></li>
<li><a href="{{route('agent.payout.transaction-history')}}">DMT Transaction History</a></li>

</ul>
</li>


<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-money me-3" aria-hidden="true"></i>
<span>Payout</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.payout.payout')}}">Payout</a></li>
<li><a href="{{route('agent.payout.payouttxn')}}">Payout Transaction History</a></li>
</ul>
</li>

<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<img src="{{url('backend/assets/images/B-removebg-preview.png')}}" width="20px" style="margin-right: 8px;" class="me-2"/>
<span>Bills</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.bbps.index')}}">Pay Bills</a></li>
<li><a href="{{route('agent.bbps.billing-history')}}">Bill History</a></li>
<li><a href="{{route('agent.bbps.complaint-registron')}}">Complaint Registration</a></li>
<li><a href="{{route('agent.bbps.search-transaction')}}">Search Transaction</a></li>
</ul>
</li>

<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-university me-3"></i>
<span>AEPS</span></a>
<ul class="sidebar-submenu">
    
@if(!isset($AEPSOnboarding) || $AEPSOnboarding->onboarding_status != 1)
<li><a href="{{route('agent.aeps.agentOnboarding')}}">Onboarding </a></li>
@elseif(empty($aeps_2factor_register) || $AEPSOnboarding->onboarding_status == 1 && $aeps_2factor_register->errorcode == 0)
<li><a href="{{route('agent.aeps.agentRegistration')}}">Aeps Registration</a></li>
@elseif(!empty($aeps_2factor_register) && $aeps_2factor_register->response_code == 1 && $aeps_2factor_register->errorcode == 2)
<li><a href="{{route('agent.aeps.agentAuthenticate')}}">Aeps Authenticate</a></li>
@elseif(!empty($aeps_2factor_register) && $aeps_2factor_register->response_code == 1 && $aeps_2factor_register->errorcode == 5)
<!--<li><a href="{{route('agent.aeps.balanceenquiry')}}">Balance Enquiry</a></li>-->
<!--<li><a href="{{route('agent.aeps.agentmerchant_authencity')}}">Cash Withdrawal</a></li>-->
<!--<li><a href="{{route('agent.aeps.ministatement')}}">Mini Statement</a></li>-->
<li><a href="{{route('agent.aeps.balanceWihdraw')}}">Aeps</a></li>
<li><a href="{{route('agent.aeps.txnstatus')}}">Cash Withdrawal Status</a></li>
<li><a href="{{route('agent.aeps.Wihdrawhistory')}}">Withdrawal History</a></li>
@endif

</ul>
</li>





<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-rss me-3"></i>
<span>Recharge</span></a>
<ul class="sidebar-submenu">

<li><a href="{{route('agent.mobileRecharge.mobileRecharge')}}">Mobile Recharge</a></li>
<li><a href="{{route('agent.mobileRecharge.mobilerechargeHistory')}}">Mobile Recharge History</a></li>


</ul>
</li>





<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-cloud-download me-3"></i>
<span>Courier</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('agent.courier.courierCreate')}}">Create Courier</a></li>
<li><a href="{{route('agent.wallet.payment_requset_history')}}">Courier History</a></li>
</ul>
</li>
<li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('agent.franchise-agreement', ['id' => Crypt::encrypt(session('AGENT_ID'))]) }}" target="_blank"><i class="icofont icofont-shield-alt me-3"></i>
<span>Franchise Agreement</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>



         
              
                </ul>
              </div>
         
            </nav>
          </div>
        </div>
        <!-- Page Sidebar Ends-->