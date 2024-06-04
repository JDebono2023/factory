<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'file_name',
        'client_name',
        'aws_name'
    ];

    protected $primaryKey = 'id';


    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'media_id');
    }
}
