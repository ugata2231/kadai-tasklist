@extends('layouts.app')

@section('content')

<div class="prose ml-4">
        <h2>id = {{ $message->id }} の詳細ページ</h2>
    </div>

    <table class="table w-full my-4">
        <tr>
            <th>id</th>
            <td>{{ $message->id }}</td>
        </tr>

        <tr>
            <th>タスク</th>
            <td>{{ $message->content }}</td>
        </tr>
    </table>

    {{-- タスク編集ページへのリンク --}}
    <a class="btn btn-outline" href="{{ route('messages.edit', $message->id) }}">このタスクを編集</a>

    {{-- タスク削除フォーム --}}
    <form method="POST" action="{{ route('messages.destroy', $message->id) }}" class="my-2">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-error btn-outline"
            onclick="return confirm('id = {{ $message->id }} のタスクを削除します。よろしいですか？')">削除</button>
    </form>

@endsection