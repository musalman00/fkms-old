<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'kiosk_participant_id',
        'picture',
        'description',
        'publish_time',
        'promotion_ends',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'publish_time' => 'datetime',
        'promotion_ends' => 'datetime',
    ];

    public function kioskParticipant()
    {
        return $this->belongsTo(KioskParticipant::class);
    }
}
