@extends('layouts.layout')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h2>{{  $post->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="card-img card-img_max" style="background-image: url({{ $post->img ?? asset('img/default.svg') }});"></div>
                    <div class="car-description mt-2 mb-2">{{  $post->description }}</div>
                    <div class="card-author">{{ $post->name }}</div>
                    <div class="card-author mt-2 mb-2">{{ $post->created_at->diffForHumans() }}</div>
                    <div class="card-btn">
                        <div class="text-right mt-3 mb-3">
                            <a href="{{ route('post.index') }}" class="btn btn-outline-info">На главную</a>
                            <a href="{{ route('post.edit', ['id' => $post->post_id]) }}" class="btn btn-outline-warning">Редактировать</a>
                            <form action="{{ route('post.destroy', ['id' => $post->post_id]) }}" method="post" onsubmit="if (confirm('Are you sure?')) { return true } else { return false }">
                            @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-outline-danger" value="Удалить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
