<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'from', 'to', 'user_id', 'updated_by'];

    protected $dates = ['deleted_at', 'from', 'to'];

    protected $appends = ['duration'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function control()
    {
        return $this->hasOne(Control::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getDurationAttribute()
    {
        return $this->to->diffInDays($this->from) + 1;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFromAttribute($value)
    {
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value);
        return $from;
    }

    public function getToAttribute($value)
    {
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value);
        return $to;
    }
}
