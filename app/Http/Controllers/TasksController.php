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
        $tasks = \Auth::user()->tasks()->get(); //Auth::userでログイン中のuser情報を取得→Usermodel(user.php)のpublic function tasks()〜returnまでを作成し準備ができたらgetしてねと言う意味に書き換え。それを$tasksに代入。 

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [ //http://localhost/tasks
            'tasks' => $tasks,
        ]);
    }

        // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [ //http://localhost/tasks/create
            'task' => $task,
        ]);
    }
    
    // postでtasks/にアクセスされた場合の「新規登録処理」(投稿の保存)
    public function store(Request $request)
    {
        // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->user_id = \Auth::id(); //migrationファイル作成時userid追加済み。データ登録時にその情報が必要。Auth::idでログイン中のidを取得し、それをtaskのuseridに代入するためのこのコードを追記。
        $task->save();

        // タスク一覧ページへリダイレクトさせる
        return redirect()->route('tasks.index'); //saveして保存後、上記で作成したpublic function index()のhttp://localhost/tasksに戻る
    }

    // getでmessages/idにアクセスされた場合の「取得表示処理」←多分、tasks/idだと思う...
    public function show($id)
    {
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id) { //もしログインしているuserのidとtask投稿を保存したueseidが合致していたらその人のものなのでreturn viewで見せていいよ。
            return view('tasks.show', [ //http://localhost/tasks/10(id=10 メッセージ詳細ページ ※10の部分はid番号によって変える)
                'task' => $task
            ]);
        }

        return view('dashboard'); //if文のところに該当しなかったら、http://localhost/dashboardに戻ってね。
    }

    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id) {
            return view('tasks.edit', [ //例：http://localhost/tasks/10/edit (id=10 メッセージの編集画面を開くページ ※10の部分はid番号によって変える)
                'task' => $task
            ]);
        }

        return view('dashboard');
    }

    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」例：http://localhost/tasks/10
    public function update(Request $request, $id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        $task->content = $request->content;
        $task->save();

        //タスク一覧ページへリダイレクトさせる
        return redirect()->route('tasks.index'); //更新をしたあと、http://localhost/tasksに戻ってね
    }

    // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (\Auth::id() == $task->user_id) { //もしログインしているuserのidとtask投稿を保存したueseidが合致していたらその人のものなので削除しても良いよ
            $task->delete();
        }
        //タスク一覧ページへリダイレクトさせる
        return redirect()->route('tasks.index');
    }
}


    