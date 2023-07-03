@extends('layouts.app')

@section('title')
    {{ $tasklist->title }}
@endsection

@section('content')
    <div class="bg-white p-3">
        <h2>Новая задача</h2>
        
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('tasklist-new-task', ['tasklist' => $tasklist->id]) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" class="form-control" id="title" name="title">

                <label for="files" class="form-label">Фотографии</label>
                <input type="file" name="images[]" id="files" class="form-control" multiple accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>

    <div class="bg-white p-3 mt-3">
        <h2>Задачи</h2>

        @foreach ($tasklist->tasks as $task)
            <ul>
                <li class="d-flex align-items-center justify-content-between">
                    <div>
                        <div>{{ $task->title }}</div>
                        <div class="d-flex">
                            @foreach ($task->images as $image)
                                <a class="me-2" href="/storage/{{ $image->name }}/full.jpeg">
                                    <picture>
                                        <source srcset="/storage/{{ $image->name }}/full.webp" type="image/webp">
                                        <source srcset="/storage/{{ $image->name }}/full.jpeg" type="image/jpeg">

                                        <img src="/storage/{{ $image->name }}/full.jpeg" style="width: 100px">
                                    </picture>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('tasklist-remove-task', ['tasklist' => $tasklist->id, 'task' => $task->id]) }}">
                            @csrf
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </li>
            </ul>
        @endforeach
    </div>
@endsection