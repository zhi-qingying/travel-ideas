@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('ideas.index') }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    
                    <div class="col-md-5 mb-3">
                        <label for="search-destination" class="font-weight-bold">Destination</label>
                        <input type="text" id="search-destination" name="destination" class="form-control" placeholder="e.g. Tokyo" value="{{ request('destination') }}">
                    </div>
                    
                    <div class="col-md-5 mb-3">
                        <label for="search-tag" class="font-weight-bold">Tag</label>
                        <input type="text" id="search-tag" name="tag" class="form-control" placeholder="e.g. Disneyland" value="{{ request('tag') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">Find Ideas!</button>
                    </div>

                </div>
            </form>
            <p class="mt-2 text-muted">Total matched records: <strong>{{ $totalCount }}</strong></p>
    </div>

    <div class="row">
        @foreach($ideas as $idea)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('ideas.show', $idea->id) }}">{{ $idea->title }}</a></h5>
                    <p class="card-text">
                        <strong>Destination:</strong> {{ $idea->destination }}<br>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($idea->start_date)->format('m/Y') }}<br>
                        <strong>Comments:</strong> {{ $idea->comments_count }}
                    </p>
                    <div class="tags">
                        @foreach($idea->tags as $tag)
                            <span class="badge badge-info">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection