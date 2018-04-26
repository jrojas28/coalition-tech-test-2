@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        {{ isset($method) ? $method : "Create"}} Task
      </div>
      <div class="panel-body">
        @if(isset($projects) && count($projects) > 0)
            <div class="col-xs-12 from-group">
                <label for="project" class="control-label">Select a Project</label>
                <select class="form-control" name="project" id="project-selector">
                    <option value="0" selected="1">All</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group col-xs-12">
            <h4>Tasks</h4>
            <hr>
            <div class="col-xs-3">
                <span class="priority">Priority</span>
                </div>
                <div class="col-xs-3">
                    <span class="name">Name</span>
                </div>
                <div class="col-xs-3">
                    <span class="project">Project</span>
                </div>
                <div class="col-xs-3">
                    <span class="timestamp">Created At</span>
                </div>
            <ul id="task-holder" style="padding: 0px;">
                @foreach($tasks as $task)
                <li style="cursor: pointer;" class="task" data-id="{{ $task->id }}" data-priority="{{ $task->priority }}">
                    <div class="col-xs-3">
                    <span class="priority">{{ $task->priority }}</span>
                    </div>
                    <div class="col-xs-3">
                    <span class="name">{{ $task->name }}</span>
                    </div>
                    <div class="col-xs-3">
                    <span class="project">{{ isset($task->project) ? $task->project->name : "None" }}</span>
                    </div>
                    <div class="col-xs-3">
                        <span class="timestamp">{{ $task->created_at }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="form-group col-xs-12">
            <h4>Create Task</h4>
            <hr>
          {!! Form::open(['action' => ['TaskController@api__store'], 'method' => 'POST', 'id' => 'task-form']) !!}
            <div class="col-xs-12 {{ isset($projects) && count($projects) > 0 ? "col-md-4" : "col-md-6" }}">
              {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            @if(isset($projects) && count($projects) > 0)
                <div class="form-group col-xs-12 col-md-4">
                {!! Form::label('project_id', 'Project', ['class' => 'control-label']) !!}
                @php
                    $projectOptionArr = $projects->pluck('name', 'id');
                    $projectOptionArr['0'] = "None";
                @endphp
                {!! Form::select('project_id', $projectOptionArr, '0', ['class' => 'form-control', 'step' => '1']) !!}
                </div>
            @endif
            <div class="form-group col-xs-12 {{ isset($projects) && count($projects) > 0 ? "col-md-4" : "col-md-6" }}">
              {!! Form::label('submit', 'Submit', ['class' => 'control-label']) !!}              
                <button type="submit" class="btn m-light-green btn-block">
                Submit
              </button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <li id="task-template" class="task hidden">
        <div class="col-xs-3">
          <span class="priority"></span>
        </div>
        <div class="col-xs-3">
          <span class="name"></span>
        </div>
        <div class="col-xs-3">
          <span class="project"></span>
        </div>
        <div class="col-xs-3">
            <span class="timestamp"></span>
        </div>
    </li>
@endsection