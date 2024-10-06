<?php

namespace App\Models\Transformers;

use App\Models\Image;
use Flugg\Responder\Transformers\Transformer;

class ImageTransformer extends Transformer{

    public function transform(Image $model){
              return ($model ? [
                "filename" => $model->original_filename,
                "src" => $model->src,
            ] : null);
    }
}