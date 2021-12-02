<?php

namespace App\Models;

use App\Utils\CanRate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    //use CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function getAvatarAttribute()
    {
        //gravatar
        $email = md5($this->email);
        return "https://i.pravatar.cc/150?u=/$email"; 
    }

    public function getProfilePhotoAttribute(){

        $path = $this->profile_photo_path;
        $email = md5($this->email);
        if($this->profile_photo_path){
            return asset("storage/$path");
        }else{
            return "https://s.gravatar.com/avatar/$email";
        }
        
    }    

    public function course(){
        return $this->hasMany(Course::class);

    }

}
