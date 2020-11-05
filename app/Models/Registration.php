<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','classroom_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }

}
