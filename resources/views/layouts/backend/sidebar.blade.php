
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
            <div class="logo-wrapper"><a href="{{route('superadmin.index')}}"><img class="img-fluid for-light sidelogo"  src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" alt=""></a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
              <!--<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>-->
            </div>
  
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn"><a href="{{route('superadmin.index')}}"></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="pin-title sidebar-main-title">
                    <div> 
                      <h6>Pinned</h6>
                    </div>
                  </li>

       <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.index')}}">
                      <svg class="stroke-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#fill-home')}}"> </use>
                      </svg><span>Dashboard</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
                      
              <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.agent.index')}}">
                      <svg class="stroke-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-user')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#fill-user')}}"> </use>
                      </svg><span>Agents</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
                      

                                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.wallet.payment_requset_history')}}">
                  <i class="fa fa-cloud-download me-3"></i>
                 <span>Payout Request</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
                      
                      
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title " >
                  <i class="icon-wallet me-3"></i><span>Wallet</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="{{route('superadmin.wallet.addmoney')}}">Add To Wallet</a></li>
                      <li><a href="{{route('superadmin.wallet.addmoneytoagent')}}">Add Agent Wallet</a></li>
                      <li><a href="{{route('superadmin.wallet.deductmoneytoagent')}}">Deduct Agent Wallet</a></li>
                      <li><a href="{{route('superadmin.wallet.transaction-history')}}">Transaction History</a></li>
                    </ul>
                  </li>
<!--<li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{route('agent.bbps.index')}}">-->
<!--                      <img src="{{url('backend/assets/images/B-removebg-preview.png')}}" width="50px" style="margin-right: 8px;"/><span>Pay Bills</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>-->
                      
                      
<li class="sidebar-list"><a class="sidebar-link sidebar-title" >
<img src="{{url('backend/assets/images/B-removebg-preview.png')}}" width="20px" style="margin-right: 8px;"/>
<span>Bills</span></a>
<ul class="sidebar-submenu">
<li><a href="{{route('superadmin.bbps.index')}}">Pay Bills</a></li>
<li><a href="{{route('superadmin.bbps.billing-history')}}">Bill History</a></li>
<li><a href="{{route('superadmin.bbps.complaint-registron')}}">Complaint Registration</a></li>
<li><a href="{{route('superadmin.bbps.search-transaction')}}">Search Transaction</a></li>
</ul>
</li>

<li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
<i class="fa fa-money me-3" aria-hidden="true"></i>
<span>AEPS</span></a>
<ul class="sidebar-submenu">

<li><a href="{{route('superadmin.txnstatus')}}">Cash Withdrawal Status</a></li>
<li><a href="{{route('superadmin.Wihdrawhistory')}}">Withdrawal History</a></li>
<li><a href="{{route('superadmin.mobilerechargeHistory')}}">Mobile Recharge History</a></li>
<li><a href="{{route('superadmin.blanceenqueryhistory')}}">Balance Enquiry History</a></li>
<li><a href="{{route('superadmin.ministatementhistory')}}">Mini Statement History</a></li>
</ul>
</li>



                      
                                            

                      <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.settings')}}">
                      <svg class="stroke-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-editors')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{url('backend/assets/svg/icon-sprite.svg#fill-editors')}}"></use>
                      </svg><span>Setting </span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a>
               
                </li>
                
                
                              <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.news.create')}}">
                    <i class="icon-signal me-3"></i><span>News</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
                      
                      
                           <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.pipe')}}">
                 <i class="fa fa-bank me-3"></i><span>Change Bank</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
                 
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('superadmin.ticket')}}">
                 <i class="icofont icofont-triangle me-3"></i><span>User Tickets</span><div class="according-menu"><i class="fa fa-angle-right"></i></div></a></li>
     
              
                </ul>
              </div>
         
            </nav>
          </div>
        </div>
        <!-- Page Sidebar Ends-->