@extends('layouts.application', [
    'title' => [
        'Competitions'
    ]
]
)

@section('content')
    <div class="page-header">
        <h1>
            Competitions
            <a class="btn btn-primary float-right" href="{{ route('admin.competitions.create') }}">
                <span class="fa fa-plus"></span>
                Add Competition
            </a>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Active</th>
                                <th>Style</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($competitions as $competition)
                                <tr>
                                    <td class="text-muted">{{ $competition->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.competitions.show', $competition) }}">{{ $competition->name }}</a>
                                    </td>
                                    <td>
                                        @if ($competition->active)
                                            <span class="status-icon bg-success"></span>
                                            Active
                                        @else<span class="status-icon bg-warning"></span>
                                            Not Active
                                        @endif
                                    </td>
                                    <td>{{ $competition->style }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($competitions->hasMorePages())
                    <div class="card-footer">
                        {{ $competitions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
