<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = ['id_number', 'id_now', 'firstname', 'middlename', 'lastname', 'group_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['group'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }


}
