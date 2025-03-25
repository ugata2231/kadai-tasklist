<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            // タスク一覧を取得
            $tasks = $user->tasks()->paginate(10);

            // タスク一覧ビューでそれを表示
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
        }
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);

        // タスクを作成
        $task = new Task;
        $task->user_id = auth()->id();
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }

    // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() !== $task->user_id) {
            return redirect('/dashboard');
        }
        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() !== $task->user_id) {
            return redirect('/dashboard');
        }

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);

        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() !== $task->user_id) {
            return redirect('/dashboard');
        }

        // タスクを更新
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }

    // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        if (\Auth::id() !== $task->user_id) {
            return redirect('/dashboard');
        }

        // タスクを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }
}