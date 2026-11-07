@extends('layouts.backend.master')
@section('page_title','settings')
@section('content')


<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>
                     Setting</h4>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('superadmin.index')}}">
                        <svg class="stroke-icon">
                          <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item active">Setting</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row size-column">
              <div class="col-xxl-10 col-md-12 box-col-8 grid-ed-12">
                <div class="row">
                  <div class="col-xxl-12 col-md-12 box-col-12">
                    <div class="row"> 
              
                      <div class="col-3"> 
                        <a href="{{route('superadmin.setting.systemSetting')}}">
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <span class="f-light">Website </span>
                            <div class="d-flex align-items-end gap-1">
                              <h5>General </h5><span class="font-primary f-12 f-w-500"></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#setting')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                        </a>
                      </div>
                      
                            <div class="col-3"> 
                        <a href="{{route('superadmin.BillCategory.create')}}">
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <span class="f-light">Bbps </span>
                            <div class="d-flex align-items-end gap-1">
                              <h5>Category </h5><span class="font-primary f-12 f-w-500"></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#setting')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                        </a>
                      </div>
                      
                                    <div class="col-3"> 
                        <a href="{{route('superadmin.mobilerecharegetexes')}}">
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <span class="f-light">Mobile Recharge</span>
                            <div class="d-flex align-items-end gap-1">
                              <h5>Tax </h5><span class="font-primary f-12 f-w-500"></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#setting')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                        </a>
                      </div>
                      
                      
                                    <div class="col-3"> 
                         <a href="{{route('superadmin.balancewithdrawltax')}}">
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <span class="f-light">Balance withdrawl </span>
                            <div class="d-flex align-items-end gap-1">
                              <h5>Tax </h5><span class="font-primary f-12 f-w-500"></span>
                            </div>
                            <div class="bg-gradient"> 
                              <svg class="stroke-icon svg-fill">
                                <use href="{{url('backend/assets/svg/icon-sprite.svg#setting')}}"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                        </a>
                      </div>

                      <!--<div class="col-3"> -->
                      <!--<a href="{{route('superadmin.scripts.create')}}">-->
                      <!--  <div class="card small-widget"> -->
                      <!--    <div class="card-body secondary"><span class="f-light">Page</span>-->
                      <!--      <div class="d-flex align-items-end gap-1">-->
                      <!--        <h5>Script</h5><span class="font-secondary f-12 f-w-500"></span>-->
                      <!--      </div>-->
                      <!--      <div class="bg-gradient"> -->
                      <!--        <svg class="stroke-icon svg-fill">-->
                      <!--          <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-sample-page')}}"></use>-->
                      <!--        </svg>-->
                      <!--      </div>-->
                      <!--    </div>-->
                      <!--  </div>-->
                      <!--  </a>-->
                      <!--</div>-->

    
                      
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection