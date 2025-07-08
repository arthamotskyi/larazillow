<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Str;

class ListingImage extends Model
{
    protected $fillable = ['filename'];
    protected $appends = ['src'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function getSrcAttribute() {
        return Str::startsWith($this->filename, ['http://', 'https://'])
        ? $this->filename
        : asset("storage/{$this->filename}");
    }
}
