<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LakM\Comments\Concerns\Commentable;
use LakM\Comments\Contracts\CommentableContract;

class EducationRoom extends Model implements CommentableContract
{
    use Commentable;
    protected $guestMode = false;
    protected $table = 'education_rooms';
    protected $fillable = ['name', 'description', 'introduction_video_path', 'purpose', 'target', 'material_path', 'youtube_link', 'reference_links', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
