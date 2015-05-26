@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit server
                        <span class="pull-right">
                            <a href="{{ route('server.show', $server) }}">Back</a>
                        </span>
                    </div>

                    <div class="panel-body">
                        @include('partials._error_message')

                        {!! Form::model($server, ['route' => ['server.update', $server], 'method' => 'PUT']) !!}
                        @include('server._form')
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        {!! Form::model($server, ['route' => ['server.destroy', $server], 'method' => 'DELETE']) !!}
                        {!! Form::submit('DELETE', ['class' => 'btn btn-danger btn-xs pull-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
