<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Models\Wechat\WechatAccount;
use Illuminate\Http\Request;
use Log;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve($app_id = 'wxcd4d79500885f523')
    {
        $accountInfo = WechatAccount::where('app_id', $app_id)->first()->toArray();
        if(!empty($accountInfo)){
            $config = [];
            $config['app_id']   =  $app_id;
            $config['secret']   =   $accountInfo['secret'];
//            $config['token']    =   $accountInfo['token'];
//            $config['aes_key']  =   $accountInfo['aes_key'];
            $app = app('wechat.official_account', $config);
        }else{
            $app = app('wechat.official_account');
        }
        $app->server->push(function($message){
            return "欢迎".date('H:i:s');
        });

        return $app->server->serve();
    }
}
