@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
                    <div>
                        <table class="table">
                            <caption>All servers.</caption>
                            <thead>
                            <tr>
                                <th>Server name</th>
                                <th>Server Address</th>
                                <th>Admin User</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($servers as $server)
                                <tr>
                                    <td>
                                        <a href="{{ route('server.show', $server) }}">{{ $server->name }}</a>
                                    </td>
                                    <td>{{ $server->address }}</td>
                                    <td>{{ $server->admin_user }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('server.create') }}" class="btn btn-primary">
                        Create Server
                    </a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
