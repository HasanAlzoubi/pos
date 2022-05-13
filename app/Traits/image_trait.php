<?php

namespace App\Traits;


Trait image_trait
{
    public function File_name($photo){
        $file_extention=$photo->getClientOriginalExtension();
        $file_name=time().'.'.$file_extention;
        return $file_name;
    }
}
