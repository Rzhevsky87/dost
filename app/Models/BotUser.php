<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_bot',
        'tlgrm_id',
        'first_name',
        'last_name',
        'username',
        'custom_username',
    ];
}
