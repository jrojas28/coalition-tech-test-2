@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        {{ isset($method) ? $method : "Create"}} Project
      </div>
      <div class="panel-body">
        <div class="form-group col-xs-12">
            <h4>Projects</h4>
            <hr>
            <div class="col-xs-6">Name</div>
            <div class="col-xs-6">Timestamp</div>
            <div id="project-holder">
                @foreach($projects as $project) 
                    <div class="col-xs-6">{{$project->name}}</div>
                    <div class="col-xs-6">{{$project->created_at}}</div>
                @endforeach
            </div>
        </div>
        <div class="form-group col-xs-12">
            <h4>New Project</h4>
            <hr>
          {!! Form::open(['action' => ['ProjectController@api__store'], 'method' => 'POST', 'id' => 'project-form']) !!}
            <div class="col-xs-12 col-md-6">
              {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-xs-12 col-md-6">
                <label for="submit" class="control-label">Submit</label>
              <button type="submit" class="btn m-light-green btn-block">
                Submit
              </button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div id="project-template" class="hidden">
        <div class="col-xs-6">
          <span class="name"></span>
        </div>
        <div class="col-xs-6">
            <span class="timestamp"></span>
        </div>
    </div>
@endsection