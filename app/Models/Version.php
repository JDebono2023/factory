<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    protected $table = 'versions';

    protected $fillable = ['version'];
    protected $primaryKey = 'id';
}
