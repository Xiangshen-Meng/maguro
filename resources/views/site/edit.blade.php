@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit site
                        <span class="pull-right">
                            <a href="{{ route('server.site.show', [$server, $site]) }}">Back</a>
                        </span>
                    </div>

                    <div class="panel-body">
                        @include('partials._error_message')

                        {!! Form::model($site, ['route' => ['server.site.update', $server, $site], 'method' => 'PUT']) !!}
                        @include('site._form')
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        {!! Form::model($server, ['route' => ['server.site.destroy', $server, $site], 'method' => 'DELETE']) !!}
                        {!! Form::submit('DELETE', ['class' => 'btn btn-danger btn-xs pull-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
