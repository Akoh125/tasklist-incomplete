<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // タスク一覧を取得
        $tasks = Task::all();         

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [     
            'tasks' => $tasks,        
        ]);                                
    }

        // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

       // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

       // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
{
    $task = Task::findOrFail($id);

    if (\Auth::id() !== $task->user_id) {
        return view('tasks.show', [
            'task' => $task
        ]);
    }

    return view('dashboard');
}

        // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
{
    $task = Task::findOrFail($id);

    if (\Auth::id() !== $task->user_id) {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    return view('dashboard');
}

    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
{
    $task = Task::findOrFail($id);

    if (\Auth::id() !== $task->user_id) {
        $task->delete();
    }

    return view('dashboard');
}
}
