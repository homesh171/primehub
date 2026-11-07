@extends('layouts.backend.master')
@section('page_title','index')
@section('content')


<style>
    .get{
        background: #54BA4A;
    color: white;
    padding: 4px 0;
    border-radius: 2px;
    }
    
    .sent{
        background: #dc3545;
    color: white;
    padding: 4px 0;
    border-radius: 2px;
    }
    
    .sentmsg{
        color:#dc3545 !important;
    }
    .getmsg{
        color:#54BA4A !important;
    }
</style>
<!--{{$totalagent}}-->
<!--₹{{$totalamount}}-->


      <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>
                     Dashboard</h4>
                </div>

              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row size-column">
              <div class="col-xxl-10 col-md-12 box-col-8 grid-ed-12">
                <div class="row">
                  <div class="col-xxl-5 col-md-7 box-col-7">
                    <div class="row"> 
                      <div class="col-sm-12"> 
                        <div class="card o-hidden">             
                          <div class="card-body balance-widget"><span class="f-w-500 f-light">Total Balance</span>
                            <h4 class="mb-3 mt-1 f-w-500 mb-0 f-22">₹<span class="counter">{{$admintotalamount->wallet}} </span></h4><a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="{{route('superadmin.wallet.addmoney')}}">Tap Up Balance</a>
                            <div class="mobile-right-img"><img class="left-mobile-img" src="{{url('backend/assets/images/dashboard-2/widget-img.png')}}" alt=""><img class="mobile-img" src="{{url('backend/assets/images/dashboard-2/mobile.gif')}}" alt="mobile with coin"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6"> 
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <span class="f-light">Total DMT</span>
                            <div class="d-flex align-items-end gap-1">
                              <h4>2,435</h4><span class="font-primary f-12 f-w-500"><i class="icon-arrow-up"></i><span>+50%</span></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6"> 
                        <div class="card small-widget"> 
                          <div class="card-body warning"><span class="f-light">Total Payout</span>
                            <div class="d-flex align-items-end gap-1">
                              <h4>2,908</h4><span class="font-warning f-12 f-w-500"><i class="icon-arrow-up"></i><span>+20%</span></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#customers')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6"> 
                        <div class="card small-widget"> 
                          <div class="card-body secondary"><span class="f-light">Total BBPS</span>
                            <div class="d-flex align-items-end gap-1">
                              <h4>$389k</h4><span class="font-secondary f-12 f-w-500"><i class="icon-arrow-down"></i></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#sale')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6"> 
                        <div class="card small-widget"> 
                          <div class="card-body success"><span class="f-light">Total Wallet Load</span>
                            <div class="d-flex align-items-end gap-1">
                              <h4>$3,908</h4><span class="font-success f-12 f-w-500"><i class="icon-arrow-up"></i></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#profit')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-md-5 col-sm-6 box-col-5"> 
                    <div class="appointment">
                      <div class="card">
                        <div class="card-header card-no-border">
                          <div class="header-top">
                            <h5 class="m-0">Recent Transaction</h5>
                            <div class="card-header-right-icon">
                              <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="{{route('superadmin.viewalltxn')}}">View All</a></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-body pt-0">
                          <div class="appointment-table customer-table table-responsive">
                            <table class="table table-bordernone">
                                          <tbody>
                            @if ($txn->isEmpty())
    <tr>
        <td colspan="2">No transactions found.</td>
    </tr>
@else
    @foreach ($txn as $tran)
        <tr>
            @if($tran->payment_status=='1')
            <td><i data-feather="arrow-down-left" class="get"></i></td>
                  <td class="img-content-box ">
                <a class="f-w-500 getmsg" href="#">{{$tran->message}}</a>
                <span class="f-light getmsg">₹{{$tran->amount}}</span>
                 <span class="f-light getmsg">Date:{{date('j M Y h:i:s',strtotime($tran->created_at))}}</span>
            </td>
            @else
          
             <td><i data-feather="arrow-up-right" class="sent"></i></td>
                   <td class="img-content-box sentmsg">
                <a class="f-w-500 sentmsg" href="#">{{$tran->message}}</a>
                <span class="f-light sentmsg">₹{{$tran->amount}}</span>
                <span class="f-light sentmsg">Date:{{date('j M Y h:i:s',strtotime($tran->created_at))}}</span>
            </td>
             @endif
            
      
        </tr>
    @endforeach
@endif

  
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
          

                </div>
              </div>

            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        
@endsection
    