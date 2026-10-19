<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'display_order',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'display_order' => 'integer',
    ];

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'category_id');
    }

    public static function seedDefaults(): void
    {
        $defaults = [
            ['name' => 'Backend', 'slug' => 'backend', 'color' => '#3b82f6', 'display_order' => 1, 'is_enabled' => true],
            ['name' => 'Frontend', 'slug' => 'frontend', 'color' => '#ef4444', 'display_order' => 2, 'is_enabled' => true],
            ['name' => 'Database', 'slug' => 'database', 'color' => '#f59e0b', 'display_order' => 3, 'is_enabled' => true],
            ['name' => 'API', 'slug' => 'api', 'color' => '#8b5cf6', 'display_order' => 4, 'is_enabled' => true],
            ['name' => 'Tools', 'slug' => 'tools', 'color' => '#10b981', 'display_order' => 5, 'is_enabled' => true],
        ];

        foreach ($defaults as $data) {
            self::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
