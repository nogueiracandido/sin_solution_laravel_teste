<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date_birth', 'gender', 'individual_registration'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function adress()
    {
        return $this->hasOne('App\Models\Address');
    }

    public function registration()
    {
        return $this->hasOne('App\Models\Registration');
    }

}
