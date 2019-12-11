<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index(Request $request)
    {

        if ($request->search) {
            $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(12);
            return view('posts/index', compact('posts'));
        }
        $title = 'Блог';
        // получаем все посты из модели
        $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(4);
        return view('posts/index', compact('posts', 'title'));
    }


    public function create()
    {
        $title = 'Создать пост';
        return view('posts.create', compact('title'));
    }


    public function store(PostRequest $request)
    {
        //dd($request);

        $post = new Post();
        $post->title = $request->title;
        $post->short_title = Str::length($request->title > 30 ? Str::substr($request->title, 0, 30) . '...' : $request->title);
        $post->description = $request->description;
        $post->author_id = rand(1,4);

        if ($request->file('img')) {
            // перемещаем загруженный файл в папку
            $path = Storage::putFile('public', $request->file('img'));
            // сохраняем путь к загруженному файлу
            $url = Storage::url($path);
            // записываем путь к картинке в бд
            $post->img = $url;
        }

        // сохраняем все в БД
        $post->save();

        // делаем редирект и выводим flesh сообщение
        return redirect()->route('post.index')->with('success', 'Пост успешно добавлен!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::join('users', 'author_id', '=', 'users.id')
            ->find($id);
        $title = $post->title;
        return view('posts.show', compact('post', 'title'));
    }


    public function edit($id)
    {
        $post = Post::find($id);

        return view('posts.edit', compact('post'));
    }


    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        $post->title = $request->title;
        $post->short_title = Str::length($request->title > 30 ? Str::substr($request->title, 0, 30) . '...' : $request->title);
        $post->description = $request->description;

        if ($request->file('img')) {
            // перемещаем загруженный файл в папку
            $path = Storage::putFile('public', $request->file('img'));
            // сохраняем путь к загруженному файлу
            $url = Storage::url($path);
            // записываем путь к картинке в бд
            $post->img = $url;
        }

        // обновляем все в БД
        $post->update();

        $id = $post->post_id;

        // делаем редирект и выводим flesh сообщение
        return redirect()->route('post.show', compact('id'))->with('success', 'Пост успешно обновлен!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // находим пост
        $post = Post::find($id);
        // удаляем пост
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Пост успешно удален!');
    }
}
