@extends('layout.master')
@section('style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')

<section class="content-header">
  <h1>
    VEGETABLE
    <small>Control panel</small>
  </h1>

  <ol class="breadcrumb">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active">Vegetable</li>
  </ol>
</section>

<div class="modal modal-info fade" id="add-vegetable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Vegetable</h4>

      </div>
      <div class="modal-body">
        <!-- Custom Tabs (Pulled to the right) -->
        <form action="#" method="POST" id="frm-vegetable-create" enctype ="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">

            <div class="form-group">
              <label for="vegetable_image" class="col-sm-3 control-label">Vegetable Image: </label>
              <div class="col-sm-9">
                <input type="file" class="form-control" name="vegetable_image" id="vegetable_image" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="vegetable_price" class="col-sm-3 control-label">Veg Price(RM): </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="vegetable_price" id="vegetable_price" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="vegetable_name" class="col-sm-3 control-label">Vegetable Name: </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="vegetable_name" id="vegetable_name" multiple="true">
              </div>
            </div>

            <div class="form-group">
              <label for="vegetable_desc" class="col-sm-3 control-label">Vegetable Desc: </label>
              <div class="col-sm-9">
              <textarea class="form-control" name="vegetable_desc" id="vegetable_desc"></textarea>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<section class="content">
  <div class="col-md-12">
    <!-- Custom Tabs (Pulled to the right) -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs ">
        <li class="active"><a href="#tab_1" data-toggle="tab">Active</a></li>
        <li class="pull-right"> 
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add-vegetable">Add Vegetable</button></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="box">

              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="mailbox-controls">

                </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped" id="vegetable-table">
                   <thead>

                    <tr class="info bg-black">

                      <th><input type="checkbox"></th>
                      <th class="mailbox-star"><center><a href="#">Vegetable Name</a></center></th>
                      <!-- <th class="mailbox-star"><center><a href="#">Vegetable Desc</a></center></th> -->
                      <th class="mailbox-star"><center><a href="#">Vegetable Price(RM/Unit)</a></center></th>
                      <th class="mailbox-star"><center><a href="#">Vegetable Image</a></center></th>
                      <th class="mailbox-subject"><center><a href="#">Operation</a></center></th>

                    </tr>
                  </thead>

                  <tbody>
                    @foreach($vegetables as $vegetable) 
                    <tr class="info">
                      <td><input type="checkbox"></td>
                      <td class="mailbox-name"><center><a href="#">{{$vegetable->vegetable_name}}</a></center></td>
                      <!-- <td class="mailbox-name"><center><a href="#">{{$vegetable->vegetable_desc}}</a></center></td> -->
                      <td class="mailbox-name"><center><a href="#">{{$vegetable->vegetable_price}}</a></center></td>
                      <td class="col-sm-3"><center><img style="width: 25%" src="{{ env('APP_PHOTO_URL') }}{{$vegetable->vegetable_image}}"></a></center></td>
                      <td class="mailbox-subject"><center><div class="btn-group">
                      <a class="button btn btn-success btn-sm" href="{{route('editVegetable', ['vegetable_id'=> $vegetable->vegetable_id])}}"><i class="fa fa-edit"></i> Edit</a>
                        {{ Form::open(array('url' => 'vegetable/' . $vegetable->vegetable_id, 'class' => 'pull-right')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', array('class' => 'button btn btn-warning btn-sm')) }}
                        {{ Form::close() }}
                      </center>
                    </td>
                  </tr>
                  @endforeach


                </tbody>

              </table>
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <!-- /.tab-pane -->

    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
</div>
<!-- Main content -->
</section>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script>
  $(document).ready(function()
  {
    $('#vegetable-table').DataTable();
    CKEDITOR.replace('vegetable_desc');

    $('#frm-vegetable-create').on('submit',function(e)
    {
      e.preventDefault();
      console.log('pressed');
      var data = $(this).serialize();

      console.log(data);
      var formData = new FormData($(this)[0]);
   formData.append('vegetable_desc', CKEDITOR.instances.vegetable_desc.getData());
   // console.log(CKEDITOR.instances.description.getData());
   $.ajax(
   {
    url:"{{route('createVegetable')}}", 
    type: "POST",
    data: formData,
    async: false,
    success: function(response)
    {
      console.log(response);
      $("[data-dismiss = modal]").trigger({type: "click"});
    },  
    cache: false,
    contentType: false,
    processData: false
  });
 });
  });

</script>
@endsection 