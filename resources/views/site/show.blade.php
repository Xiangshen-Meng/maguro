@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Site
                        <span class="pull-right">
                            <a href="{{ route('site.edit', $site) }}">Edit</a>
                        </span>
                    </div>

                    <div class="panel-body">
                        <h4>Site Name</h4>
                        <p>{{ $site->name }}</p>
                        <h4>Site Domain</h4>
                        <p>{{ $site->domain }}</p>
                        <h4>Site Port</h4>
                        <p>{{ $site->port }}</p>
                        <hr/>
                        <h4>Cleanup Default Bash</h4>
                        <blockquote>
                            {{ $site->cleanupDefaultBash() }}
                        </blockquote>
                        <h4>Create Site Bash</h4>
                        <blockquote>
                            {{ $site->createBash() }}
                        </blockquote>
                        <h4>Remove Site Bash</h4>
                        <blockquote>
                            {{ $site->removeBash() }}
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
