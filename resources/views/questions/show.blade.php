@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route("questions.index") }}" class="btn btn-outline-secondary">
                                        Back to all Questions
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="This question is useful" class="vote-up" href="">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">1232</span>
                                <a title="This question is not useful" class="vote-down off" href="">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <a title="Click to mark as favorite question (Click again to undo"
                                   class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->isFavorited() ? 'favorited' : '') }}"
                                   href=""
                                   onclick="event.preventDefault();
                                       document.getElementById('question-favorite-{{$question->id}}').submit();">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{ $question->favorites_count }}</span>
                                </a>
                                <form action="/questions/{{ $question->id }}/favorites"
                                      id="question-favorite-{{$question->id}}" method="post" style="display: none">
                                    @csrf
                                    @if($question->isFavorited())
                                        @method('DELETE')
                                    @endif
                                </form>
                            </div>
                            <div class="media-body">
                                {!!  $question->body_html !!}
                                <div class="float-right">
                                <span class="text-muted">
                                    Asked {{ $question->created_date }}
                                </span>
                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">
                                                {{ $question->user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('answers._index', [
            'answers' => $question->answers,
            'answersCount' => $question->answers_count
        ])
        @include('answers._create')
    </div>
@endsection
