@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Server
                        <span class="pull-right">
                            <a href="{{ route('server.edit', $server) }}">Edit</a>
                        </span>
                    </div>

                    <div class="panel-body">
                        <h4>Server name</h4>
                        <p>{{ $server->name }}</p>
                        <h4>Server address</h4>
                        <p>{{ $server->address }}</p>
                        <h4>Admin user</h4>
                        <p>{{ $server->admin_user }}</p>
                        <hr/>
                        <a href="{{ route('server.create') }}" class="btn btn-primary">
                            Create Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
