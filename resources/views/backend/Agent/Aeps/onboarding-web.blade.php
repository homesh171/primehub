@extends('layouts.backend.agent.master')
@section('page_title','Agent Onboarding')
@section('content')
@php
$date = date('Y-m-d H:i:s');
 @endphp
    
 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Onboarding</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
              
                  <div class="card-body">
                    <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" enctype="multipart/form-data" action="{{route('aeps.proceedOnboarding')}}">
                        @csrf
                    @include('layouts.flash-message')
                      <div class="col-4">
                        <label class="form-label" for="validationCustom01">Merchant Code<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Merchant Code" name="amount" value="{{$user['agent_id']}}" required="" disabled>
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
     
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01">Mobile Number<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Mobile Number" name="amount" value="{{$user['mobile_number']}}" required="" disabled>
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                        </div>
                        
                        
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01">Email<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="email" placeholder="Enter Email" name="amount" value="{{$user['email']}}" required="" disabled>
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                        </div>

      
                    @if(empty($Onboarding['user_id']))
                      <div class="col-12 text-center">
                         <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Proceed to onboarding</button>
                      </div>
                  
                        @endif  
                      
               
                    
                        @if(isset($Onboarding) && $responseDataStatus['status']==false && $Onboarding->txnid==null && $Onboarding->createtime >= $date)
                         <div class="">
                   <div class="col-12 text-center">
                       <p style="color: red; font-size: 16px;">Onboarding Successfully. Please click the button below to proceed. </p>
                         <button class="btn btn-success" ><a href="{{$Onboarding->redirecturl}}" class="btn btn-success" target="_blank">Proceed</a></button>
                      </div>
                    </div>
                    @elseif(isset($Onboarding) && $Onboarding->txnid !=null)
                                <div class="">
                   <div class="col-12 text-center">
                   
                         <button class="btn btn-primary" ><a href="{{route('agent.aeps.agentOnboardingStatus')}}" class="btn btn-primary" >Check onboarding Status</a></button>
                      </div>
                    </div>
                          
             
                   @elseif(isset($Onboarding) && $Onboarding->txnid ==null && $date >= $Onboarding->createtime )
                   
                       <div class="col-12 text-center">
                         <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure?')">Proceed to onboarding</button>
                      </div>
                  
                    @endif
                         </form>
                    <div>
                       
                    </div>
                    
                    
                    <div>

    
                    </div>
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
                 
                       @push('scripts')
      
     <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<!--    <script>-->
<!--       $(document).ready(function() {-->

<!--    $.ajax({-->
<!--        url: '{{route('aeps.agentOnboardingCallback')}}',-->
<!--        method: 'post',-->
<!--        success: function(response) {-->
            
<!--            if (response.status === 200) {-->
            
<!--                swal({-->
<!--                    title: "Success",-->
<!--                    text: response.message,-->
<!--                    type: "success"-->
<!--                }).then(function() {-->
                 
<!--                    window.location.reload();-->
<!--                });-->
<!--            }-->
<!--        },-->
<!--        error: function(xhr, status, error) {-->
         
<!--        }-->
<!--    });-->
<!--});-->

<!--    </script>-->
    @endpush
       @endsection