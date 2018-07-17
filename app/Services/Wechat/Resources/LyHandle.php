<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 2018/7/3
 * Time: 上午9:46
 */

namespace App\Services\Wechat\Resources;

use App\Http\Controllers\Api\LyMetaController;
use App\Services\Wechat\Music;
use Log;

class LyHandle
{
    public static function process($keyword)
    {
        $appCopyName = '公众号:永不止息';

        $lyMeta = LyMetaController::get_liangyou_audio_list();
        $isLyApp = true;
        $oriKeyword = $keyword; //6031
        $keyword = substr($oriKeyword, 0, 3);   //3位数关键字xxx
        $offset = substr($oriKeyword, 3) ?: 0;  // todo 1-3-7
        $itemKey = 'index';
        $keyArray = array_pluck($lyMeta, 'index');  //601-635
        if ($isLyApp) {
            $itemKey = 'lywx';
            $keyArray = array_pluck($lyMeta, $itemKey); //102-201-901
            $appCopyName = '公众号:良友知音';
        }
        $code = null;
        foreach ($lyMeta as $key => $item) {
            if ($item[$itemKey] == $keyword) {
                $code = $key;
            }
        }
        //region
        if (!$code) {
            return null;
        }

        //todo return json for api.
        if (in_array($keyword, $keyArray)) {
            $res = LyMetaController::get($code, $offset);
            //回复音乐
            if (is_array($res)) {
                $res['description'] .= ' '.$appCopyName;
                if (!$offset) {
                    $res['description'] .= ' 每日更新';
                }

                return new Music($res);
            } else {
                //回复文本//text 上下范围7天内无节目

                return $res;
            }
        }
        //endregion
    }
}