<?php

namespace App\Http\Controllers;

use App\Models\MediaPlatformMessages;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use App\Models\MediaPlatformConfig;
use Log;

class MediaPlatformController extends Controller
{
    protected $mediaPlatformConfig;

    /**
     * MediaPlatformController constructor.
     * @param MediaPlatformConfig $mediaPlatformConfig
     */
    public function __construct(MediaPlatformConfig $mediaPlatformConfig)
    {
        $this->mediaPlatformConfig = $mediaPlatformConfig;
    }

    /**
     * 公众号服务端
     * @param string $code
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \ReflectionException
     */
    public function service(string $code)
    {

        $mediaPlatformConfig = $this->mediaPlatformConfig->where(['media_platform_code' => $code])->first();

        if (empty($mediaPlatformConfig)) {
            return result(404, '未找到该公众号配置');
        }

        $config = [
            'app_id' => $mediaPlatformConfig['account_appid'],
            'secret' => $mediaPlatformConfig['account_secret'],
            'token' => $mediaPlatformConfig['account_token'],
            'aes_key' => $mediaPlatformConfig['account_aes_key'],
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        ];

        $app = Factory::officialAccount($config);

        $app->server->push(function ($message) use ($code, $mediaPlatformConfig) {

            $time = date('Y:m:d H:i:s');

            Log::info("{$time},微信发送数据：" . json_encode($message));

            if (!empty($message)) {
                $messageData = [
                    'to_user_name' => $message['ToUserName'],
                    'from_user_name' => $message['FromUserName'],
                    'create_time' => $message['CreateTime'],
                    'msg_type' => $message['MsgType'],
                    'msg_id' => $message['MsgId'] ?? 0,
                    'original_data' => $message,
                    'media_platform_code' => $code,
                    'media_platform_name' => $mediaPlatformConfig['media_platform_name'],
                ];

                switch ($message['MsgType']) {
                    case 'event':
                        if ($message['Event'] == 'subscribe') {

                            return $mediaPlatformConfig['subscribe_message'];

                        } elseif ($message['Event'] == 'unsubscribe') {

                        }

                        break;
                    case 'text':
                        $messageData['content'] = $message['Content'];
                        break;
                    case 'image':
                        $messageData['pic_url'] = $message['PicUrl'];
                        $messageData['media_id'] = $message['MediaId'];
                        break;
                    case 'voice':
                        $messageData['format'] = $message['Format'];
                        $messageData['media_id'] = $message['MediaId'];
                        $messageData['recognition'] = $message['Recognition'] ?? '';
                        break;
                    case 'video':
                        $messageData['thumb_media_id'] = $message['ThumbMediaId'];
                        $messageData['media_id'] = $message['MediaId'];
                        break;
                    case 'location':
                        $messageData['location_x'] = $message['Location_X'];
                        $messageData['location_y'] = $message['Location_Y'];
                        $messageData['scale'] = $message['Scale'];
                        $messageData['label'] = $message['Label'];
                        break;
                    case 'link':
                        $messageData['title'] = $message['Title'];
                        $messageData['description'] = $message['Description'];
                        $messageData['url'] = $message['Url'];
                        break;
                    case 'file':
                        return '收到文件消息';
                    case 'shortvideo':
                        $messageData['thumb_media_id'] = $message['ThumbMediaId'];
                        $messageData['media_id'] = $message['MediaId'];
                        break;
                    default:
                        return '';
                        break;
                }

                MediaPlatformMessages::create($messageData);
            }
        });

        return $app->server->serve();

    }
}
