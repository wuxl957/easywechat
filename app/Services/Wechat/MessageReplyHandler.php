<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 2018/7/2
 * Time: 下午2:22
 */

namespace App\Services\Wechat;

use \EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use App\Services\Wechat\Resources\LyHandle;

class MessageReplyHandler implements EventHandlerInterface
{
    public function handle($message = null)
    {
        $handle = 'handle_'.$message['MsgType'];

        return $this->$handle($message);
    }

    /**
     * @param $message
     * @return string
     */
    public static function handle_text($message)
    {
        $keyword = strip_tags(trim($message['Content']));
        //TODO filter 空格！
        $reply = null;
        //只处理数字
        if (preg_match('/\d+/', $keyword)) { //todo 判断是否开启资源
            //todo 汉字关键词：旷野吗哪 语音识别 昨天的，今天的
            $reply = LyHandle::process($keyword);
        }

        return $reply;
    }
}