@extends('layouts.backend.master')
@section('page_title','Bbps Category')
@section('content')
     
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Bbps Category Add</h4>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('superadmin.index')}}">                                       
                        <svg class="stroke-icon">
                          <use href="{{url('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Bbps Category</li>
                    <li class="breadcrumb-item active">Bbps Category</li>
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
                            <form id="formatscriptadd-update" novalidate="novalidate" class="row g-3  custom-input" action="{{route('superadmin.BillCategory.store')}}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    
                                    <div class="form-group row mt-2">
                                        <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Category Title<span class="text-danger text-sm">*</span></label>
                                            <input type="text" class="form-control mt-2"  placeholder="Category Title" name="category" id="category" required="">
                                            <span style="color:red">@error ('category') {{$message}}@enderror</span>
                                        </div>
                                        
                                         <div class="col-sm-12">
                                            <label for="" class="col-sm-3 col-form-label">Category Image <span class="text-danger text-sm">*</span></label>
                                              <input type="file" class="form-control mt-2" placeholder="image" name="image"  required="" />
                                              <input type="hidden" class="form-control mt-2" placeholder="image" name="image" id="image" required="" />
                                              <span style="color:red">@error ('image') {{$message}}@enderror</span>

                                             
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
                                <th>Category</th>
                                <th>Image</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                      @php
                      $i = 1;
                      @endphp
                        @foreach($cate as $data)
                              <tr>
                                 <td>{{$i++;}}</td>
                                 <td>{{$data->category}}</td>
                                 <td><img src="{{url('backend/uploads/BbpsCategory/'.$data->image)}}" width="70px"/></td>
                                <td> 
                                  <ul class="action"> 
                                  <li onclick="updatescriptdata('{{Crypt::encrypt($data->id)}}','{{$data->category}}','{{$data->image}}');" class="edit socmediadata "> <i class="icon-pencil-alt"></i></li>
                            <li class="delete"><a href="{{route('superadmin.BillCategory.delete',['id'=>Crypt::encrypt($data->id)])}}" onclick="return confirm('Are You Sure?')"><i class="icon-trash"></i></a></li>  
                                  </ul>
                                </td>
                              </tr>
                              @endforeach
                       
                           
                            </tbody>
                          </table>
                             <div class="pagination-container">
                              {!! $cate->links("pagination::bootstrap-4") !!}
                            </div>
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
          
          <script>
          

function updatescriptdata(id, category, image) {
    var url = '{{ url('superadmin/BillCategory/update') }}/' + id;
    $('#formatscriptadd-update').attr('action', url);
    $('#category').val(category);
    $('#image').val(image);
    // Don't set the value of the file input field
};

</script>
          
          @endpush
          
          @endsection