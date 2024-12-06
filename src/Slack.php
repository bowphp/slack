<?php

namespace Bow\Slack;

class Slack
{
    /**
     * The webhook url
     *
     * https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXX
     *
     * @var string
     */
    private $url;

    /**
     * Slack constructor
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Send the message
     *
     * @param SlackMessage $message
     *
     * @return boolean
     */
    public function send(SlackMessage $message)
    {
        $data = $message->toArray();

        $json = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->url,
            CURLOPT_USERAGENT => 'cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => ['payload' => $json],
        ));

        $result = curl_exec($curl);

        if (!$result) {
            return false;
        }

        curl_close($curl);

        if ($result == 'ok') {
            return true;
        }

        return false;
    }

    /**
     * Set the webhook url
     *
     * @param string $url
     *
     * @return Slack
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
