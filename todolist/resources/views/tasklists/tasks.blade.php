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

        <form method="POST" action="{{ route('tasklist-new-task', ['tasklist' => $tasklist->id]) }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>

    <div class="bg-white p-3 mt-3">
        <h2>Задачи</h2>

        @foreach ($tasklist->tasks as $task)
            <ul>
                <li>
                    {{ $task->title }}
                </li>
            </ul>
        @endforeach
    </div>
@endsection