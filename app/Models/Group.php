<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LakM\Comments\Concerns\Commentable;
use LakM\Comments\Contracts\CommentableContract;

class Group extends Model implements CommentableContract
{
    use Commentable;
    protected $guestMode = false;
    protected $fillable = [
        'name',
        'room_id',
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
