<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\isEmpty;

class CodeGenerator{
    
    public static function generate($key)
    {
        $result = Redis::get($key);
        if($result==""){
            $result = 1;
        }else{
            $result = (int)$result +1 ;
        }
        Log::info("REDIS_".$key.'_'.$result);

        Redis::set($key,$result,'EX',60*60*24);
        return $result;
    }
  
}