<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = ['name', 'symbol', 'iso_code_str', 'iso_code_num', 'exchange_currency'];

}
