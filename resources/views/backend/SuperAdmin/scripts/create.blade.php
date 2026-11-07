     @extends('layouts.backend.master')
@section('page_title','Scipts')
@section('content')
     
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Page Script Add</h4>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Page Script</li>
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
                                <h5 class="modal-title">Edit Taxes</h5>
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
                            <form id="formatscriptadd-update" novalidate="novalidate" class="row g-3 needs-validation custom-input" action="{{route('superadmin.scripts.store')}}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    
                                    <div class="form-group row mt-2">
                                        <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">URL<span class="text-danger text-sm">*</span></label>
                                            <input type="text" class="form-control mt-2" id="urlname" placeholder="URL" name="url_name" required="">
                                        </div>
                                        
                                         <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Script <span class="text-danger text-sm">*</span></label>
                                             <textarea class="form-control" id="scriptname" rows="6" name="script" required></textarea>
                                            
                                        </div>


                                    </div>
                
                                    
                                    <div class="form-group mt-4">
                                        <button class="btn btn-primary" value="submit" type="submit">Submit</button>
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
                   
                <div class="col-md-7 mt-2 main-content">
                
                    <div class="card">
                      <div class="card-body">

                        <div class="table-responsive">
                
                          <table class="display" id="basic-1">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>URL</th>
                                <th>Script</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                      @php
                      $i = 1;
                      @endphp
                        @foreach($script as $scripts)
                              <tr>
                                 <td>{{$i++;}}</td>
                                 <td>{{$scripts->url_name}}</td>
                                 <td>{{$scripts->script}}</td>
                                <td> 
                                  <ul class="action"> 
                                  <li onclick="updatescriptdata('{{$scripts->id}}','{{$scripts->url_name}}','{{$scripts->script}}');" class="edit socmediadata "> <i class="icon-pencil-alt"></i></li>
                            <li class="delete"><a href="{{route('superadmin.scripts.delete',['id'=>$scripts->id])}}" onclick="return confirm('Are You Sure?')"><i class="icon-trash"></i></a></li>  
                                  </ul>
                                </td>
                              </tr>
                              @endforeach
                       
                           
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                
                    </div>

                </div>
            </div>
          </div>
          
          @push('scripts')
          
          <script>
function updatescriptdata(id,url_name,script){
       var url = '{{ url('superadmin/scripts/update') }}/' + id;
 $('#formatscriptadd-update').attr('action',url);
$('#urlname').val(url_name);
$('#scriptname').val(script); 


};
</script>
          
          @endpush
          
          @endsection