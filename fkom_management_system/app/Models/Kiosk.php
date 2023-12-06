<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kiosk extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['number', 'name', 'description'];

    protected $searchableFields = ['*'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function kioskParticipants()
    {
        return $this->hasMany(KioskParticipant::class);
    }
}
