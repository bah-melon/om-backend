<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'description',
        'employment_type',
        'user_id'
    ];

    public function applicants(){
        return $this->hasMany(Applicants::class, "open_positions");
    }
}
