<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
     public function favorites()
    {
        return $this->belongsToMany(Micropost::class, 'user_favorite', 'micropost_id', 'user_id')->withTimestamps();
    }
    
    public function favoritings()
    {
        return $this->belongsToMany(Micropost::class, 'user_favorite', 'user_id', 'micropost_id')->withTimestamps();
    }
    
     public function favorite($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_favoriting($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->favoritings()->attach($userId);
            return true;
        }
    }

    public function unfavorite($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_favoriting($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->favoritings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
}
