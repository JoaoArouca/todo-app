@extends('layouts.app')

@section('title', 'To Do App')

@section('content')
    <main class="container collumn">
        @livewire('input-task')
        @livewire('task-list')
    </main>
@endsection
