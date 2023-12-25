<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'amount', 'qr_picture', 'status'];

    protected $searchableFields = ['*'];

    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
