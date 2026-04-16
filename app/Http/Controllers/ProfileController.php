<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user) 
        {
            $ideas = $user->travelIdeas()->withCount('comments')->latest()->get();
            return view('profile.show', compact('user', 'ideas'));
        }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Server-side validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // 改成 profile_picture
            'bio' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'profile_picture.image' => 'Profile picture must be an image',
            'profile_picture.max' => 'Profile picture cannot exceed 2MB',
            'bio.max' => 'Bio cannot exceed 500 characters',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update bio
        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }

        // Handle profile picture upload (改成 profile_picture)
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Store new picture
            $picturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $picturePath;
        }

        $user->save();

        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully!');

    }
}