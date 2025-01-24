@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Tasks</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
    <ul class="list-group mt-3">
        @foreach($tasks as $task)
            <li class="list-group-item">
                <strong>{{ $task->title }}</strong>
                <p>{{ $task->description }}</p>
                <small>Created at: {{ $task->created_at }}</small>
            </li>
        @endforeach
    </ul>
</div>
@endsection
