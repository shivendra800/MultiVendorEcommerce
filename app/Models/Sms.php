<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function sendSms($message,$mobile)
    {
                /*Code for SMS Script Starts*/
            $request ="";
            $param['authorization']="HfiwAnP83YMWQu01khBL5CSVrGUpXE4xya7IFtKgoml2N9jTJOypErmvOFfDgbSIsXwR8hWJG1B29NMq";
            $param['sender_id'] = 'FastSM';
            $param['message']= '$message';
            $param['numbers']= '$mobile';
            $param['language']="english";
            $param['route']="p";

            foreach($param as $key=>$val) {
                $request.= $key."=".urlencode($val);
                $request.= "&";
        }
            $request = substr($request, 0, strlen($request)-1);

            $url ="https://www.fast2sms.com/dev/bulk?".$request;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curl_scraped_page = curl_exec($ch);
            curl_close($ch);
            /*Code for SMS Script Ends*/
    }
}
