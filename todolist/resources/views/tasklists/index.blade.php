@extends('layouts.app')

@section('title')
    Списки задач
@endsection

@section('content')
    <div class="bg-white p-3">
        <h2>Новый список</h2>
        
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('tasklist-create') }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>

    <div class="bg-white p-3 mt-3">
        <h2>Списки</h2>

        @foreach ($tasklists as $tasklist)
            <ul>
                <li class="d-flex align-items-center justify-content-between">
                    <a class="d-block" href="{{ route('tasklist-tasks', ['tasklist' => $tasklist->id]) }}">
                        {{ $tasklist->title }}
                    </a>
                    <div>
                        <form method="POST" action="{{ route('tasklist-remove', ['tasklist' => $tasklist->id]) }}">
                            @csrf
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </li>
            </ul>
        @endforeach
    </div>
@endsection