<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Standard extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'changed_at' => 'datetime',
        'publication_date' => 'datetime',
        'withdrawn_date' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Helper method to fetch column names for this models table without requiring
     * a hydrated model instance.
     * 
     * @return array
     */
    public static function getTableColumns()
    {
        return Schema::getColumnListing((new self)->getTable());
    }
}
