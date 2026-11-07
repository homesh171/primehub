@extends('layouts.backend.master')
@section('page_title','settings')
@section('content')
<style>
    .error{
        margin:3px 0px !important;
        color:red !important;
    }
</style>

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
 @include('layouts.flash-message')
        <form id="myform" method="POST" action="{{ route('superadmin.updatebalancewithdrawltax') }}">
        @csrf
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <td>Start Price</td>
                    <td>Last Price</td>
                    <td>Commission</td>
                    <td>Tax</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="TextBoxContainer">
                @foreach($charges as $index => $charge)
                    <tr>
                        <td>
                            <input type="hidden" name="charges[{{ $index }}][id]" value="{{ $charge->id }}">
                            <input name="charges[{{ $index }}][start_price]" type="number" class="form-control" value="{{ $charge->start_price }}" required=""/>
                        </td>
                        <td>
                            <input name="charges[{{ $index }}][last_price]" type="number" class="form-control" value="{{ $charge->last_price }}" required=""/>
                        </td>

                        <td>
                            <input name="charges[{{ $index }}][commission]" type="number" class="form-control" value="{{ $charge->commission }}" required=""/>
                        </td>
                        <td>
                            <input name="charges[{{ $index }}][tax]" type="number" class="form-control" value="{{ $charge->tax }}" required=""/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove" data-id="{{ $charge->id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <button id="btnAdd" type="button" class="btn btn-primary" data-toggle="tooltip" data-original-title="Add more controls">
                            <i class="fa fa-plus"></i>&nbsp; Add&nbsp;
                        </button>
                    </th>
                </tr>
            </tfoot>
        </table>
        <div>
        <input type="hidden" name="deleted_ids" id="deleted_ids" value="">
        <button type="submit" class="btn btn-success mt-2">Save Changes</button>
        </div>
    </form>
    
                      
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
  @push('scripts')
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>        
<script>
$(function () {
    var cn = {{ $charges->count() }};
    var deletedIds = [];

    $("#btnAdd").bind("click", function () {
        var div = $("<tr />");
        div.html(GetDynamicTextBox("", cn));
        $("#TextBoxContainer").append(div);
        cn = cn + 1;
    });

    $("body").on("click", ".remove", function () {
        var id = $(this).data("id");
        if (id) {
            deletedIds.push(id);
            $('#deleted_ids').val(deletedIds.join(","));
        }
        $(this).closest("tr").remove();
    });

    $('#myform').validate({
        rules: {
            'charges[][start_price]': {
                required: true,
                number: true
            },
            'charges[][last_price]': {
                required: true,
                number: true
            },
            'charges[][charges_amount]': {
                required: true,
                number: true
            }
        }
    });
});

function GetDynamicTextBox(value, cn='') {
    return '<td><input name="charges[' + cn + '][start_price]" type="number" class="form-control" required=""/></td>'
        + '<td><input name="charges[' + cn + '][last_price]" type="number" class="form-control" required=""/></td>'
        + '<td><input name="charges[' + cn + '][commission]" type="number" class="form-control" required=""/></td>'
        + '<td><input name="charges[' + cn + '][tax]" type="number" class="form-control" required=""/></td>'
        + '<td><button type="button" class="btn btn-danger remove"><i class="fa fa-trash-o"></i></button></td>';
}



</script>

 
          
          @endpush

@endsection