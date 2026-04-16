@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Column: User Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Avatar -->
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             class="rounded-circle" 
                             width="150" 
                             height="150"
                             style="object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width:150px;height:150px;">
                            <span class="text-white display-1">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <!-- User Name -->
                    <h3 class="mt-3">{{ $user->name }}</h3>
                    
                    <!-- Email -->
                    <p class="text-muted">{{ $user->email }}</p>
                    
                    <!-- Bio -->
                    <p>{{ $user->bio ?? 'No bio yet. Click edit to add one!' }}</p>
                    
                    <!-- Edit Button -->
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Column: Travel Ideas List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">My Travel Ideas</h5>
                </div>
                <div class="card-body">
                    @forelse($ideas as $idea)
                        <div class="mb-3 pb-3 border-bottom">
                            <h5>
                                <a href="{{ route('ideas.show', $idea) ?? '#' }}" class="text-decoration-none">
                                    {{ $idea->title }}
                                </a>
                            </h5>
                            <p class="mb-1">
                                📍 {{ $idea->destination }}
                            </p>
                            <p class="mb-1">
                                📅 {{ date('m/Y', strtotime($idea->start_date)) }}
                            </p>
                            <p class="mb-0 text-muted">
                                💬 {{ $idea->comments_count ?? 0 }} comments
                            </p>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">
                            No travel ideas yet.
                            <br>
                            <a href="{{ route('ideas.create') }}" class="btn btn-sm btn-primary mt-2">
                                Create Your First Travel Idea
                            </a>
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection