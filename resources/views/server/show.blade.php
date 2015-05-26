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
                        <div>
                            <table class="table">
                                <caption>All sites.</caption>
                                <thead>
                                <tr>
                                    <th>Site Name</th>
                                    <th>Site Domain</th>
                                    <th>Site Port</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($sites as $site)
                                    <tr>
                                        <td>
                                            <a href="{{ route('server.site.show', [$server, $site]) }}">{{ $site->name }}</a>
                                        </td>
                                        <td>{{ $site->domain }}</td>
                                        <td>{{ $site->port }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('server.site.create', $server) }}" class="btn btn-primary">
                            Create Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
