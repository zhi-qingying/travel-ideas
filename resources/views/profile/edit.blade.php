@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">✏️ Edit Profile</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            <div class="form-text">We'll never share your email with anyone else.</div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Profile Picture Field -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Profile Picture</label>
                            
                            @if($user->profile_picture)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                             alt="Current Profile Picture" 
                                             class="rounded-circle border" 
                                             width="80" 
                                             height="80"
                                             style="object-fit: cover;">
                                        <span class="ms-2 text-muted small">Current picture</span>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Accepted formats: JPG, JPEG, PNG. Maximum size: 2MB.</div>
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio Field -->
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" 
                                      name="bio" 
                                      rows="4" 
                                      placeholder="Tell your friends about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            <div class="form-text">Maximum 500 characters. Tell others about your travel interests!</div>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-secondary">
                                ← Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                💾 Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Help Card -->
            <div class="card mt-3 bg-light">
                <div class="card-body">
                    <small class="text-muted">
                        <strong>💡 Tip:</strong> 
                        - All fields marked with <span class="text-danger">*</span> are required<br>
                        - Your profile picture will be stored securely<br>
                        - Your bio helps friends know more about your travel style
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection