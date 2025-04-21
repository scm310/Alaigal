<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'member_references';

    protected $fillable = [
        'reference_to',
        'reference_from',
        'reference_by',
        'title',
        'amount',
        'date',
        'image',
        'details',
        'reference_type',
    ];

    public function givenTo()
    {
        return $this->belongsTo(Members::class, 'reference_to');
    }

    public function givenBy()
    {
        return $this->belongsTo(Members::class, 'reference_from');
    }
}
