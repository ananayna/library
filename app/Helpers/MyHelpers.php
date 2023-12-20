<?php
namespace App\Helpers;

use App\Models\Category;

trait MyHelpers{
    public function slug_Generator($string, $model){
        $slug = str()->slug($string);
        $count = $model::where('slug', 'LIKE', '%' . $slug . '%')->count();
        if ( $count > 0){
            $count += 1 ;
            $slug = $slug . '-' . $count;
        }else{
            $slug = $slug;
        }
        return $slug;
    }

    public function ImageUplode($filled_name, $destination, $type = 'public'){
            $image = str()->random(5).time().'.'.$filled_name->extension();
            $filled_name->storeAs($destination, $image, $type);

        return $image;
    }
}
