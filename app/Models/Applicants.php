<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Applicants extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'phoneNumber',
        'email',
        'city',
        'country',
        'file_path',
        'description',
        'open_positions',
    ];

    public function getFileUrl(){
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function openPosition(){
        return $this->belongsTo(OpenPosition::class, 'open_positions');
    }
}
