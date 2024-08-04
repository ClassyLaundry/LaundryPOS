<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'action_model', 'action_id', 'model'];

    public function getModelInstanceFromAction(UserAction $userAction, $path)
    {
        $model = app($path); // Adjust the namespace as needed
        $modelData = json_decode($userAction->model, true);
        $model->fill($modelData);
        return $model;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
