<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MailingFile extends Pivot
{
    public $incrementing = true;
    public $timestamps = true;

    protected $table = 'mailing_files';

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function mailing() : BelongsTo
    {
        return $this->belongsTo(Mailing::class);
    }
}
