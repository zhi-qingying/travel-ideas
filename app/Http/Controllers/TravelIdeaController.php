<?php

namespace App\Http\Controllers;

use App\Models\TravelIdea;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelIdeaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $query = TravelIdea::with(['user', 'tags'])->withCount('comments');

        // 1. If the user provided a destination keyword, we filter ideas by destination
        if ($request->filled('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        // 2. If the user provided a tag, we need to filter ideas that have that tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                // Search tags by name with partial match
                $q->where('name', 'like', '%' . $request->tag . '%');
            });
        }

        $ideas = $query->latest()->get();
        $totalCount = $ideas->count(); // 显示匹配记录总数

        return view('ideas.index', compact('ideas', 'totalCount'));
    }

    public function create()
    {
        return view('ideas.create');
    }

   
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'destination' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $idea = Auth::user()->travelIdeas()->create($request->only([
            'title', 'destination', 'start_date', 'end_date'
        ]));

        // Process tags
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['name' => trim($name)]);
                $idea->tags()->attach($tag->id);
            }
        }

        return redirect()->route('ideas.index')->with('success', 'Idea created successfully!');
    }

    public function show(TravelIdea $idea)
    {

        $idea->load(['user', 'tags', 'comments.user']);
        return view('ideas.show', compact('idea'));
    }

    public function edit(TravelIdea $idea)
    {
        // Only the owner can edit their idea 
        if (Auth::id() !== $idea->user_id) {
            abort(403);
        }
        return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, TravelIdea $idea)
    {
        if (Auth::id() !== $idea->user_id) abort(403);

        $request->validate([
            'title' => 'required|max:255',
            'destination' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $idea->update($request->only(['title', 'destination', 'start_date', 'end_date']));

        // Update tags
        if ($request->tags) {
            $tagIds = [];
            foreach (explode(',', $request->tags) as $name) {
                $tag = Tag::firstOrCreate(['name' => trim($name)]);
                $tagIds[] = $tag->id;
            }
            $idea->tags()->sync($tagIds);
        }

        return redirect()->route('ideas.show', $idea->id)->with('success', 'Idea updated!');
    }

    public function destroy(TravelIdea $idea)
    {
        if (Auth::id() !== $idea->user_id) abort(403);
        $idea->delete();
        return redirect()->route('ideas.index')->with('success', 'Idea deleted!');
    }
}