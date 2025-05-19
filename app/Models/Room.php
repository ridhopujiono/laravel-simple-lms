<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'name',
        'description',
        'instruction',
        'file_path',
        'created_by',
    ];
    public function groups() {
        return $this->hasMany(Group::class);
    }
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
