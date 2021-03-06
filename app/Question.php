<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Parsedown;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
//        $Parsedown = new Parsedown();
//        return $Parsedown->text($this->body);
        return Parsedown::instance()->text($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', Auth::id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->favorites();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
