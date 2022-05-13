<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    //protected $appends=['image_path','full_name'];

    protected $fillable = [
        'first_name','last_name', 'email', 'password','image',
    ];


    protected $hidden = [
        'password', 'remember_token','updated_at','created_at'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected function getFirstNameAttribute($value){
        return ucfirst($value);
    }
    protected function getLastNameAttribute($value){
        return ucfirst($value);
    }

    protected function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function getImagePathAttribute(){
        return asset('uploads/user_images/'.$this->image);
    }


}
