<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use App\Models\ModelTranslation;
use Illuminate\Database\Eloquent\Model;

trait ModelAction
{



    private function saveTranslation(Model $model ,array $data ,string $key ) :void{

            $translations = [];
            $model->translations()->where("key",$key)->delete();
            foreach ($data as $locale => $value) {
                if ($value && $locale != 'default') {
                    $translations[] = new ModelTranslation([
                        'locale' => $locale,
                        'key'    => $key,
                        'value'  => $value,
                    ]);
                }
            }

            if (!empty($translations)) {
                $model->translations()->saveMany($translations);
            }

    }




    
}