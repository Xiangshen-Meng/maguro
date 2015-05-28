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
                                <th>Site Name</th>
                                <th>Site Domain</th>
                                <th>Site Port</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sites as $site)
                                <tr>
                                    <td>
                                        <a href="{{ route('site.show', $site) }}">{{ $site->name }}</a>
                                    </td>
                                    <td>{{ $site->domain }}</td>
                                    <td>{{ $site->port }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('site.create') }}" class="btn btn-primary">
                        Create Site
                    </a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
