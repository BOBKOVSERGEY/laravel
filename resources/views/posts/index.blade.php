@extends('layouts.layout')

@section('content')

        @if(isset($_GET['search']))
            @if(count($posts) > 0)
                <h1>Результаты поиска по запросу "<?php echo $_GET['search']; ?>"</h1>
                <p>Всего найдено "{{ count($posts)  }}" постов</p>
                @else
                <h2>По запросу "<?php echo $_GET['search']; ?>" ничего не найдено.</h2>
                <a href="{{ route('post.index')  }}"> Отобразить все посты</a>
                @endif
        @endif
    <div class="row">
        @foreach($posts as $post)
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h2><a href="{{ route('post.show', ['id' => $post->post_id]) }}">{{  $post->title }}</a></h2>
                </div>
                <div class="card-body">
                    <div class="card-img" style="background-image: url({{ $post->img ?? asset('img/default.svg') }});"></div>
                    <div class="car-description mt-2 mb-2">{{  $post->description }}</div>
                    <div class="card-author">{{ $post->name }}</div>
                    <div class="text-right mt-3 mb-3">
                        <a href="{{ route('post.show', ['id' => $post->post_id]) }}" class="btn btn-info">Далее</a>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
        {{-- пагинация --}}
        {{  $posts->links()  }}

@endsection
