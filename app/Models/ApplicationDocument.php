<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    const TYPE_ID_CARD = 'id_card';
    const TYPE_PASSPORT = 'passport';
    const TYPE_INCOME_PROOF = 'income_proof';
    const TYPE_BANK_STATEMENT = 'bank_statement';

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
