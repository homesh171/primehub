@extends('layouts.backend.agent.master')
@section('page_title','Change Password')
@section('content')

<style>
    span{
        color:red;
    }
</style>

        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>Change Password</h3>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="edit-profile">
              <div class="row">
                <div class="col-xl-4">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title mb-0">Change Password</h4>
                      <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                                @include('layouts.flash-message')
                      <form method="post" action="{{route('agent.updateAgentpassword')}}">
                          @csrf
                        <div>
                          <label class="form-label">Current Password</label>
                          <input class="form-control" placeholder="Enter Current Password" type="password" name="current_password">
                          <span>@error ('current_password') {{$message}}  @enderror</span>
                        </div>
                        <div>
                          <label class="form-label">New Password </label>
                          <input class="form-control" placeholder="Enter New Password" type="password" name="new_password">
                          <span>@error ('new_password') {{$message}}  @enderror</span>
                        </div>
                        <div>
                          <label class="form-label">Confirm Password</label>
                          <input class="form-control" placeholder="Enter Confirm Password" type="text" name="confirm_password">
                          <span>@error ('confirm_password') {{$message}}  @enderror</span>
                        </div>
                        <div class="form-footer">
                          <button class="btn btn-primary btn-block" type="submit">Update Password</button>
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