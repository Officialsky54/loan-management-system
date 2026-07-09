<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];

    const TYPE_ID_CARD = 'id_card';
    const TYPE_PASSPORT = 'passport';
    const TYPE_BANK_STATEMENT = 'bank_statement';
    const TYPE_EMPLOYMENT_LETTER = 'employment_letter';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
