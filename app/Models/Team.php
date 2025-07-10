<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    // Relate team to add_users instead of default users table
 public function users()
{
    return $this->belongsToMany(AddUser::class, 'team_user', 'team_id', 'user_id');
}
 public function team()
    {
        return $this->belongsTo(Team::class);
    }
}