<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'anggotas';

    protected $fillable = ['nama', 'email', 'no_telepon'];
}