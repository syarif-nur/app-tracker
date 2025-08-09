<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogObserver
{
    public function created(Model $model)
    {
        $this->log('create', $model, null, $model->getAttributes());
    }

    public function updated(Model $model)
    {
        $this->log('update', $model, $model->getOriginal(), $model->getAttributes());
    }

    public function deleted(Model $model)
    {
        $this->log('delete', $model, $model->getOriginal(), null);
    }

    protected function log($action, Model $model, $before, $after)
    {
        // Hindari log untuk model Log itu sendiri
        if ($model instanceof Log) return;
        Log::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => get_class($model),
            'model_id' => $model->getKey(),
            'data_before' => $before,
            'data_after' => $after,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}
