<?php

use Illuminate\Support\Facades\Storage;

function alert($type, $messages, $with_exit = true)
{

    $messages = collect($messages ?: null);

    return view("helpers.messages.alert", compact("type", "messages", "with_exit"));
}

function selected($value1, $value2)
{
    return ($value1 == $value2) ? "selected" : "";
}

function validationErrors()
{
    return view("helpers.messages.validation");
}

function sanitize($input)
{
    return $input ? trim(filter_var(trim($input), FILTER_SANITIZE_STRING)) : null;
}

function getJsonFromLocal($path)
{
    return collect(json_decode(Storage::disk("local")->get("json/$path.json")));
}
