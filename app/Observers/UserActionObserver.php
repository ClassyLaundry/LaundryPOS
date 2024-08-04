<?php

namespace App\Observers;

use App\Models\UserAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserActionObserver
{
    //Dijalankan Ketika Menyimpan, melakukan Pencatatan siapa yang melakukan.
    public function saved($model)
    {
        if ($model->wasRecentlyCreated) {
            $action = 'created';
        } else {
            $action = 'updated';
        }

        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => $action,
                'action_model' => $model->getTable(),
                'action_id'    => $model->id,
                'model'        => $model,
            ]);
        }
    }

    //Dijalankan Ketika Melakukan Hapus, melakukan Pencatatan siapa yang melakukan.
    public function deleting($model)
    {
        Log::info($model);
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => 'deleted',
                'action_model' => $model->getTable(),
                'action_id'    => $model->id,
                'model' => $model
            ]);
        }
    }
}
