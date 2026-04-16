@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Travel Idea</div>
        <div class="card-body">
            <form action="{{ route('ideas.update', $idea->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" value="{{ $idea->title }}" required maxlength="255">
                </div>

                <div class="form-group">
                    <label>Destination:</label>
                    <input type="text" name="destination" class="form-control" value="{{ $idea->destination }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Start Date:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $idea->start_date }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>End Date:</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $idea->end_date }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tags (Separate by comma):</label>
                    <input type="text" name="tags" class="form-control" value="{{ $idea->tags->pluck('name')->implode(', ') }}">
                </div>

                <button type="submit" class="btn btn-primary">Update Idea</button>
                <a href="{{ route('ideas.show', $idea->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection