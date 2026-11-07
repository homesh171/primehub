     @extends('layouts.backend.master')
@section('page_title','News')
@section('content')
     
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>News Add</h4>
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
                            <form id="formatscriptadd-update" novalidate="novalidate" class="row g-3 needs-validation custom-input" action="{{route('superadmin.news.store')}}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    
        
                                        
                                         <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Title <span class="text-danger text-sm">*</span></label>
                                             <textarea class="form-control" id="title" rows="6" name="title" required></textarea>
                                            
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
                
                          <table class="table " id="basic">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                      @php
                      $i = 1;
                      @endphp
                        @foreach($news as $scripts)
                              <tr>
                                 <td>{{$i++;}}</td>
                                 <td>{{$scripts->title}}</td>
                                <td> 
                                  <ul class="action"> 
                                  <li onclick="updatescriptdata('{{$scripts->id}}','{{$scripts->title}}');" class="edit socmediadata "> <i class="icon-pencil-alt"></i></li>
                            <li class="delete"><a href="{{route('superadmin.news.delete',['id'=>$scripts->id])}}" onclick="return confirm('Are You Sure?')"><i class="icon-trash"></i></a></li>  
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
                  </div>
          @push('scripts')
          
          <script>
function updatescriptdata(id,title){
       var url = '{{ url('superadmin/news/update') }}/' + id;
 $('#formatscriptadd-update').attr('action',url);
$('#title').val(title); 


};
</script>
          
          @endpush
          
          @endsection