<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $table = "submissions";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'file',
        'user_id',
        'assessment_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function assessment(): BelongsTo {
        return $this->belongsTo(Assessment::class);
    }
}
