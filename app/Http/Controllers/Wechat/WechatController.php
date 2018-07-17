<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Models\Wechat\WechatAccount;
use App\Services\Wechat\MessageReplyHandler;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve($app_id = 'wxcd4d79500885f523')
    {
        $isDebug = config('app.debug');
        $isProduction = !$isDebug;
        $app = app('wechat.official_account');
        if ($isProduction) {
            $accountInfo = WechatAccount::where('app_id', $app_id)->first()->toArray();
            /* @var $app \EasyWeChat\officialAccount\Application */
            $webot = null;
            //初始化 $webot by profile or default profile.
            if (!empty($accountInfo)) {
                $config = [];
                $config['app_id'] = $app_id;
                $config['secret'] = $accountInfo['secret'];
                //$config['token']    =   $accountInfo['token'];
                //$config['aes_key']  =   $accountInfo['aes_key'];
                $app = app('wechat.official_account', $config);
//            $app = Factory::officialAccount($config);
            }
        }
        /* @var $server \EasyWeChat\Kernel\ServerGuard */
        $server = $app->server;
        //默认回复！
//        dd(storage_path()."/public/posts/post1-small.jpg");
//        $result = $app->material->uploadImage(storage_path()."/app/public/posts/post1-small.jpg");
//        dd($result);
//        $thumb_media_id = ;
        //fail call back menu
        $server->push(
            function ($message) {
                return "欢迎关注，指令无效，请回复【600】获取节目列表";
            }
        );
        //最后一个处理作为最后返回！
        $server->push(MessageReplyHandler::class);
//        $message = $server->getMessage();
        $response = $server->serve();

        return $response;
    }
}
