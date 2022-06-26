<?php

namespace App;

use Illuminate\Support\Facades\Log;
use App\SmsLogModel;

class SmsLog
{

    public static function addLog($data, $container)
    {
        if ($container == 'file') {
            Log::useFiles(storage_path() . '/logs/jawaly.log');
            $insert = Log::info(json_encode($data));
            return [true];
        } elseif ($container == 'database') {
            try {
                $insert = SmsLogModel::create($data);
                return [true];
            } catch (\PDOException $ex) {
                return [false, $ex->getMessage()];
            }
        }
    }

}
