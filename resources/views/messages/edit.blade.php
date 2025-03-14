@extends('layouts.app')

@section('content')

<div class="prose ml-4">
        <h2 class="text-lg">id: {{ $message->id }} の編集ページ</h2>
    </div>

    <div class="flex justify-center">
        <form method="POST" action="{{ route('messages.update', $message->id) }}" class="w-1/2">
            @csrf
            @method('PUT')

                <div class="form-control my-4">
                    <label for="content" class="label">
                        <span class="label-text">タスク:</span>
                    </label>
                    <input type="text" name="content" value="{{ $message->content }}" class="input input-bordered w-full">
                </div>

                <div class="form-control my-4">
                    <label for="status" class="label">
                        <span class="label-text">status:</span>
                    </label>
                    <input type="text" name="status" value="{{ $message->status }}" class="input input-bordered w-full">
                </div>

            <button type="submit" class="btn btn-primary btn-outline">更新</button>
        </form>
    </div>

@endsection