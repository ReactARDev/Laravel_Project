@extends('admin.master')
@section('title','Create a new Channel |')
@section('contentHeader')
  <h1>Create Channel</h1>
@endsection

@section('content')
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Create News</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <form class="form-horizontal" action="{{ secure_url('moderator/channel/storeChannel') }}" method="post">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">News ID</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="id" placeholder="News ID" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">News Title</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="title" placeholder="News Title" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">News Article</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="article" placeholder="News Article" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">News Image</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="description" placeholder="Channel Description" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">Event Name</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="e_name" placeholder="Event Name" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">Feed Url</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="feed_url" placeholder="Feed Url" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">Language</label>
          <div class="col-md-10">
              <input type='text' class="form-control" name="language" placeholder="Language" required/>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" name="submit" value="back" class="btn btn-default">Save and back</button>
        <button type="submit" name="submit" value="new" class="btn btn-info pull-right">Save and Add new</button>
      </div>
      <!-- /.box-footer -->
    </form>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
@endsection

@section('footerScripts')
  <script src="{{ secure_asset('js/moment.js') }}"></script>
  <script src="{{ secure_asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
  <link rel="stylesheet" href="{{ secure_asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
  <script>
    // $(function ($) {
    //   $('.datetimepicker').datetimepicker({
    //     'format':'YYYY-MM-DD HH:mm'
    //   });
  
    //   $('#nation').change(function(){
    //     $.get("{{ secure_url('moderator/getNationCompetitions')}}",
    //       { option: $(this).val() },
    //       function(data) {
    //         var competition = $('#competition');
    //         competition.empty();
        
    //         $.each(data, function(index, element) {
    //           competition.append("<option value='"+ element.competition_id +"'>" + element.competition_name + "</option>");
    //         });
    //       });
    //   });
    // });
  </script>
@endsection