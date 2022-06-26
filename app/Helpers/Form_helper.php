<?php

use Illuminate\Support\Collection;

class Form
{
    public static function input($name, $attributes = [])
    {
        $attributes = self::set_attributes($name, $attributes);
        return view("helpers.form.input", $attributes)->render();
    }

    public static function file($name, $attributes = [])
    {
        $attributes["type"] = $attributes["type"] ?? "image";
        $attributes         = self::set_attributes($name, $attributes);

        return view("helpers.form.file", $attributes)->render();
    }

    public static function textarea($name, $attributes = [])
    {
        $attributes = self::set_attributes($name, $attributes);

        return view("helpers.form.textarea", $attributes)->render();
    }

    public static function select($name, $dataArray, $attributes = [])
    {
        $attributes              = self::set_attributes($name, $attributes);
        $attributes["value"]     = self::array_to_collect($attributes["value"]);
        $attributes["dataArray"] = self::array_to_collect($dataArray);

        return view("helpers.form.select", $attributes)->render();
    }

    public static function boolean_select($name, $attributes = [])
    {
        $dataArray                     = ["yes", "no"];
        $attributes["nameFunction"]    = function($item) { return __("labels.$item");};
        $attributes["valueFunction"]   = function($item) {return ($item == "yes" ? "1" : "0");};
        $attributes["with_not_exists"] = false;

        return self::select($name, $dataArray, $attributes);
    }

    public static function submit($attributes = [])
    {
        $attributes['title'] = $attributes['title'] ?? __("validation.attributes.save");
        $attributes['icon']  = $attributes['icon'] ?? "";

        return view("helpers.form.submit", $attributes)->render();
    }

    private static function set_attributes($name, $attributes)
    {
        /**
         * General
         */

        $attributes["name"]        = $name;
        $attributes["id"]          = $attributes["id"] ?? $name;
        $attributes["title"]       = $attributes["title"] ?? __("validation.attributes.$name");
        $attributes["placeholder"] = $attributes["placeholder"] ?? "";
        $attributes["required"]    = $attributes["required"] ?? true;
        $attributes["type"]        = $attributes["type"] ?? "text";

        $attributes["value"] = old($name) ?? $attributes["value"] ?? null;

        $attributes["help"]        = $attributes["help"] ?? "";
        $attributes["hidden"]      = $attributes["hidden"] ?? false;
        $attributes["tooltip"]     = $attributes["tooltip"] ?? "";
        $attributes["extra"]       = $attributes["extra"] ?? "";
        $attributes["class"]       = $attributes["class"] ?? "";
        $attributes["input_width"] = $attributes["input_width"] ?? 12;
        $attributes["label_width"] = $attributes["label_width"] ?? 6;

        /**
         * Textarea
         */

        $attributes["ckeditor"] = $attributes["ckeditor"] ?? true;

        /**
         * File
         */

        $attributes["multiple"]            = $attributes["multiple"] ?? false;
        $attributes["accept"]              = $attributes["accept"] ?? "image/*";
        $attributes["multiple_delete_url"] = $attributes["multiple_delete_url"] ?? null;
        $attributes["multiple_file_url"]   = $attributes["multiple_file_url"] ?? null;

        if ($attributes["multiple"]) {
            $attributes["value"] = $attributes["value"] ?? collect();
        }

        /**
         * Select
         */

        $attributes["valueFunction"]   = $attributes["valueFunction"] ?? function($item) { return $item ?? null;};
        $attributes["nameFunction"]    = $attributes["nameFunction"] ?? function($item) { return $item ?? null;};
        $attributes["with_search"]     = $attributes["with_search"] ?? true;
        $attributes["with_not_exists"] = $attributes["with_not_exists"] ?? true;

        return $attributes;
    }

    /**
     * @return Collection
     */
    private static function array_to_collect($array)
    {
        return is_array($array) ? collect($array) : $array;
    }
}
