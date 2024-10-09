<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['option_name', 'option_value'];

    public static function add($name, $value)
    {
        return self::create([
            'option_name' => $name,
            'option_value' => $value,
        ]);
    }

    public static function updateOption($name, $value)
    {
        $option = self::where('option_name', $name)->first();

        if ($option) {
            $option->update(['option_value' => $value]);
            return $option;
        }

        return self::add($name, $value);
    }

    public static function getOption($name, $default = null)
    {
        $option = self::where('option_name', $name)->first();
        return $option ? $option->option_value : $default;
    }

    public static function deleteOption($name)
    {
        return self::where('option_name', $name)->delete();
    }
}