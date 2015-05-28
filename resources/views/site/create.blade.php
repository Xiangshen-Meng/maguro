@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Create site</div>

                    <div class="panel-body">
                        @include('partials._error_message')

                        {!! Form::open(['route' => 'site.store']) !!}
                        @include('site._form')
                        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
