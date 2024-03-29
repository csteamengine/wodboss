<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function isActive($featureName)
    {
        if (auth()->user() != null && auth()->user()->isAdmin()) {
            return true;
        }

        $feature = Feature::where('name', $featureName)->first();

        if (!is_null($feature)) {
            return $feature->is_active;
        }
        return false;
    }

    public function toggleOff($featureName)
    {
        $feature = Feature::where('name', $featureName)->first();

        if (!is_null($feature)) {
            $feature->is_active = false;
            if ($feature->save()) return true;
        }
        return false;
    }

    public function toggleOn($featureName)
    {
        $feature = Feature::where('name', $featureName)->first();

        if (!is_null($feature)) {
            $feature->is_active = true;
            if ($feature->save()) return true;
        }
        return false;
    }
}
