<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebsiteSetting extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value'];
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function all($columns = ['*'])
    {
        return parent::all($columns);
    }
}
