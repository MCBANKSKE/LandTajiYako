<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCounty extends Model
{
    protected $fillable = ['county_id', 'constituency_name', 'ward', 'alias'];
    
    public $timestamps = false;
    
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }
   
}
