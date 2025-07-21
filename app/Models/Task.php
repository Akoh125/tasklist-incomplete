<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function user() { //taskmodel(Task.php)の方から誰の投稿かみやすくするためにuserメソッドを追加
        return $this->belongsTo(User::class);
    }
}

