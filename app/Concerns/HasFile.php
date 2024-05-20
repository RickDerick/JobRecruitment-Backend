<?php

namespace App\Concerns;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function hasFiles(Request $request) : bool
    {
        return count($request->allFiles()) > 0;
    }

    public function saveFiles(Model $model, array $files): void
    {
        foreach ($files as $file){
            $attachment = new Attachment();
            $attachment->model = $model::getModelName($model);
            $attachment->model_id = $model->id;
            $attachment->attachment =  generate_file_name($model).'.'.$file->getClientOriginalExtension();

            Storage::disk('attachments')->put($attachment->attachment, file_get_contents( $file));

            $attachment->save();
        }
    }
}
