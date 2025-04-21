<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thanksnote extends Model
{
    use HasFactory;

    protected $table = 'member_thanksnote';

    protected $fillable = [
        'source_member_id',
        'thanksnote_to',
        'reference_id',
        'thanksnote_title',
        'thanksnote_amount',
        'date',
    ];

    public function sourceMember()
    {
        return $this->belongsTo(Members::class, 'source_member_id');
    }

    public function thanksnoteTo()
    {
        return $this->belongsTo(Members::class, 'thanksnote_to');
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class, 'reference_id');
    }
}
