<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'kiosk_participant_id',
        'title',
        'category',
        'description',
        'attachment',
        'technician_assign',
        'reply',
        'status',
    ];

    protected $searchableFields = ['*'];

    public function kioskParticipant()
    {
        return $this->belongsTo(KioskParticipant::class);
    }
}
