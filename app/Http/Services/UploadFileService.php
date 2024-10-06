<?php


namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UploadFileService{
    public function setImage(UploadedFile $uploadedFile, Model $model, $disk){
        $filename = Str::random(20) . '.' . $uploadedFile->getClientOriginalExtension();
        $fullFile = $filename[0] . DIRECTORY_SEPARATOR . $filename[1] . DIRECTORY_SEPARATOR . $filename;
        Storage::disk("candidates")->putFileAs('', $uploadedFile, $fullFile);
        $image = new Image([
            'original_filename' => $uploadedFile->getClientOriginalName(),
            'disk' => $disk,
            'filename' => $filename
        ]);
        $image->save();

        if($model->image){
            $model->image->delete();
        }

        $model->image_id = $image->id;
    }
}