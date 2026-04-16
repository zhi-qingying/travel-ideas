@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $idea->title }}</h2>
                    <p class="text-muted">
                        Author: <a href="{{ route('profile.show', $idea->user_id) }}" class="font-weight-bold text-primary">{{ $idea->user->name }}</a> | 
                        Destination: {{ $idea->destination }} | 
                        Date: {{ \Carbon\Carbon::parse($idea->start_date)->format('m/Y') }}
                    </p>
                    <hr>
                    <div class="tags mb-3">
                        @foreach($idea->tags as $tag)
                            <span class="badge badge-info">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    @if(Auth::id() === $idea->user_id)
                        <div class="actions mt-3">
                            <a href="{{ route('ideas.edit', $idea->id) }}" class="btn btn-sm btn-warning">Edit Idea</a>
                            <form action="{{ route('ideas.destroy', $idea->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this idea?')">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">Comments (<span id="comment-count">{{ $idea->comments->count() }}</span>)</div>
                <div class="card-body">
                    
                    <div id="comment-list" class="mb-4">
                        @foreach($idea->comments()->latest()->get() as $comment)
                            <div class="comment mb-2 p-2 border-bottom">
                                <strong>{{ $comment->user->name }}:</strong> 
                                <span>{{ $comment->content }}</span>
                                <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>

                    <form id="comment-form">
                        @csrf
                        <input type="hidden" name="travel_idea_id" value="{{ $idea->id }}">
                        <textarea id="comment-content" name="content" class="form-control" rows="3" placeholder="Write a comment..." required maxlength="255"></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(function() {
                            const ideaId = "{{ $idea->id }}";

                            // 加载评论
                            function loadComments() {
                                $.get("{{ route('ideas.show', $idea) }}", function(res) {
                                    let html = $(res).find('#comment-list').html();
                                    $('#comment-list').html(html);
                                    
                                    // 顺便更新评论数量
                                    let count = $(res).find('#comment-count').text();
                                    $('#comment-count').text(count);
                                });
                            }

                            // 每2秒自动刷新（老师要求的实时更新）
                            setInterval(loadComments, 2000);

                            // 提交评论
                            $('#comment-form').submit(function(e) {
                                e.preventDefault();
                                $.post("{{ route('comments.store') }}", $(this).serialize(), function() {
                                    $('#comment-content').val(''); // 清空输入框
                                    loadComments(); // 提交后立即刷新评论列表
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div id="idea-meta-data" data-destination="{{ $idea->destination }}" data-tags="{{ $idea->tags->pluck('name')->implode(',') }}"></div>
            
            @include('components.api-widgets')
        </div>
    </div>
</div>
@endsection