<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function favorites() {
        /*
         * Mặc định Laravel sẽ ngầm coi bảng trung gian là question_user, vì
            ở đây ta đặt tên khác là favorites nên ta cần truyền tên bảng vào để Laravel hiểu
         * Đối số thứ 3 và 4: user_id, question_id có thể không cần truyền vào vì Laravel
            ngầm hiểu mặc định lấy nametable_id, nếu trong bảng trung gian đặt tên khác thì
            phải truyền đối số vào.
        */
        return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id')
            ->withTimestamps();
    }

    public function getUrlAttribute()
    {
//        return route("questions.show", $this->id);
        return "#";
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
//        $default = "https://www.somewhere.com/homestar.jpg";
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }
}
