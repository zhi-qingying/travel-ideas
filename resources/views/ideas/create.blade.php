@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Post a New Travel Idea</div>
        <div class="card-body">
            <form action="{{ route('ideas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" required maxlength="255"> </div>

                <div class="form-group">
                    <label>Destination:</label>
                    <input type="text" name="destination" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Start Date:</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>End Date:</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tags (Separate by comma):</label>
                    <input type="text" name="tags" class="form-control" placeholder="e.g. Tokyo, Disneyland, Family">
                </div>

                <button type="submit" class="btn btn-success">Post Idea</button>
            </form>
        </div>
    </div>
</div>
@endsection