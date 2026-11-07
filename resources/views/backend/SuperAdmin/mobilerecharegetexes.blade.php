@extends('layouts.backend.master')
@section('page_title','Mobile Recharge Tax')
@section('content')
     
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Mobile Recharge Tax</h4>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('superadmin.index')}}">                                       
                        <svg class="stroke-icon">
                          <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Mobile Recharge Tax</li>
                    <li class="breadcrumb-item active">Mobile Recharge Tax</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
   
         <div class="row">
                  <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Mobile Recharge Tax</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body p-0">
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-5 mt-2">
                        <div class="card card-info">
                             @include('layouts/flash-message')
                            <form id="formatscriptadd-update" novalidate="novalidate" class="row g-3  custom-input" action="{{route('superadmin.updatemobilerecharegetexes',['id'=>$charges->id])}}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    
                                    <div class="form-group row mt-2">
                                        <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Commission<span class="text-danger text-sm">*</span></label>
                                            <input type="number" class="form-control mt-2"  placeholder="Commission" name="commission"  required="" value="{{$charges->commission}}">
                                            <span style="color:red">@error ('commission') {{$message}}@enderror</span>
                                        </div>
                                        
                                         <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Tax<span class="text-danger text-sm">*</span></label>
                                              <input type="number" class="form-control mt-2" placeholder="Tax" name="tax"  required="" value="{{$charges->tax}}"/>
                                              <span style="color:red">@error ('tax') {{$message}}@enderror</span>

                                             
                                        </div>


                                    </div>
                
                                    
                                    <div class="form-group mt-4">
                                        <button class="btn btn-primary" value="submit" type="submit">update</button>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center">
                                        <div class="form-group" id="error_box">
                
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/.card-->
                    </div>
                   </div>
             
          </div>
          </div>
          </div>
          @push('scripts')

          
          @endpush
          
          @endsection