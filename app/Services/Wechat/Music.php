<?php
/**
 * Created by PhpStorm.
 * User: dale
 * Date: 2018/7/14
 * Time: 下午10:30
 */

namespace App\Services\Wechat;

use EasyWeChat\Kernel\Messages\Message;

/**
 * Class Music.
 *
 * @property string $url
 * @property string $hq_url
 * @property string $title
 * @property string $description
 * @property string $thumb_media_id
 * @property string $format
 */
class Music extends Message
{
    /**
     * Messages type.
     *
     * @var string
     */
    protected $type = 'music';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
        'title',
        'description',
        'url',
        'hq_url',
        'thumb_media_id',
        'format',
    ];

    public function toXmlArray()
    {
        $music = [
            'Music' => [
                'Title' => $this->get('title'),
                'Description' => $this->get('description'),
                'MusicUrl' => $this->get('url'),
                'HQMusicUrl' => $this->get('hq_url'),
            ],
        ];
        if ($thumbMediaId = $this->get('thumb_media_id')) {
            $music['ThumbMediaId'] = $thumbMediaId;
        }

        return $music;
    }
}
