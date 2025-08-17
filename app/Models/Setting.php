<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'is_encrypted',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_encrypted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the value attribute with decryption if needed.
     */
    public function getValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }

    /**
     * Set the value attribute with encryption if needed.
     */
    public function setValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Get settings by section.
     */
    public static function getBySection($section)
    {
        return Cache::remember("settings.{$section}", 3600, function () use ($section) {
            return self::where('section', $section)->pluck('value', 'key');
        });
    }

    /**
     * Get a specific setting value.
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value.
     */
    public static function set($key, $value, $section = 'general', $type = 'text', $isEncrypted = false)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'section' => $section,
                'value' => $value,
                'type' => $type,
                'is_encrypted' => $isEncrypted,
            ]
        );

        Cache::forget("setting.{$key}");
        Cache::forget("settings.{$section}");

        return $setting;
    }

    /**
     * Clear settings cache.
     */
    public static function clearCache()
    {
        Cache::flush();
    }
}