<?php

const JSON_PATH = "../member_data.json";

/**
 * Slackへのポスト情報を担うクラス
 */
class SlackBotInfo
{
    private   $channel;
    private   $username;
    private   $icon_emoji;
    protected $message = '';
    protected $url;

    /**
     * コンストラクタ
     */
    public function __construct($message = '')
    {
        $json = json_decode(file_get_contents(JSON_PATH));

        if( $json->slack_bot->enable ) {
            $this->set_param($json);
        }

        $this->set_message($message);
    }

    /**
     * jsonのデータを読み込んで設定する
     */
    public function set_param($json)
    {
        $this->channel    = $json->slack_bot->channel;
        $this->username   = $json->slack_bot->username;
        $this->icon_emoji = $json->slack_bot->icon_emoji;
        $this->url        = $json->slack_bot->url;
    }

    /**
     * WebhookのURLを設定する
     */
    public function set_url($url)
    {
        $this->url = $url;
    }

    /**
     * ポストするメッセージを設定する
     */
    public function set_message($message)
    {
        $this->message = $message;
    }

    /**
     * Slackへのポスト情報を返す
     */
    public function get_post_info()
    {
        return array(
            'url'  => $this->url,
            'body' => array(
                'payload' => json_encode(array(
                    'channel'    => $this->channel,
                    'username'   => $this->username,
                    'icon_emoji' => $this->icon_emoji,
                    'text'       => $this->message,
                )),
            ),
        );
    }
}

?>