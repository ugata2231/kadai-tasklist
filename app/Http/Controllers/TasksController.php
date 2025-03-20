<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            // メッセージ一覧を取得
            $messages = $user->tasks()->paginate(10);

            // メッセージ一覧ビューでそれを表示
            return view('messages.index', [
                'messages' => $messages,
            ]);
        }
    }

    // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $message = new Task;

        // メッセージ作成ビューを表示
        return view('messages.create', [
            'message' => $message,
        ]);
    }

    // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
        'content' => 'required',
        'status' => 'required|max:10',
        ]);

        // メッセージを作成
        $message = new Task;
        $message->user_id = auth()->id();
        $message->content = $request->content;
        $message->status = $request->status;
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }

    // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show(string $id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);

        if (\Auth::id() === $message->user_id) {
            // メッセージ詳細ビューでそれを表示
            return view('messages.show', [
                'message' => $message,
            ]);
         } else {
            return redirect('/dashboard');
        }
    }

    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit(string $id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('messages.edit', [
            'message' => $message,
        ]);
    }

    // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);

        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);
        // メッセージを更新
        $message->content = $request->content;
        $message->status = $request->status;
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy(string $id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);
        // メッセージを削除
        $message->delete();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }
}