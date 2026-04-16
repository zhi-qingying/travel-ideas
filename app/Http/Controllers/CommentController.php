<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'travel_idea_id' => 'required|exists:travel_ideas,id',
            'content' => 'required|max:255'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'travel_idea_id' => $validated['travel_idea_id'],
            'content' => $validated['content']
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user')
        ]);
    }
}
