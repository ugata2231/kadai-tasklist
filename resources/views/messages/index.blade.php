@extends('layouts.app')

@section('content')

<div class="prose ml-4">
        <h2 class="text-lg">タスク一覧</h2>
    </div>

    @if (isset($messages))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                <tr>
                    <td><a class="link link-hover text-info" href="{{ route('messages.show', $message->id) }}">{{ $message->id }}</a></td>
                    <td>{{ $message->content }}</td>
                    <td>{{ $message->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- タスク作成ページへのリンク --}}
    <a class="btn btn-primary" href="{{ route('messages.create') }}">新規タスクの投稿</a>

@endsection