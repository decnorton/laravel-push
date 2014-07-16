<?php namespace Dec\Push\Adapters;

use Dec\Push\Collection\DeviceCollection;
use Dec\Push\Collection\PushResponseCollection;
use Dec\Push\Gcm\GcmMessage;
use Dec\Push\Gcm\GcmNotification;
use Dec\Push\Gcm\GcmResponse;
use Dec\Push\Models\Message;
use Dec\Push\Models\PushNotification;
use Dec\Push\Collection\PushResult;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class GcmAdapter extends BaseAdapter {

    const URL = 'https://android.googleapis.com/gcm/send';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    function __construct($config = null)
    {
        // Get the config
        $this->config = is_array($config) && ! empty($config)
            ? $config
            : $this->getDefaultConfig();

        $this->apiKey = $this->config['api_key'];

        if ( ! $this->apiKey)
            throw new \InvalidArgumentException("Missing api_key");

        $this->client = new Client();
    }

    /**
     * @param $content
     * @param $parameters
     * @return GcmMessage
     */
    public function createMessage($content, $parameters)
    {
        return new GcmMessage($content, $parameters);
    }

    /**
     * @param DeviceCollection $devices
     * @param Message $message
     * @return PushNotification
     */
    public static function createPush(DeviceCollection $devices, Message $message)
    {
        return new GcmNotification($devices, $message);
    }

    /**
     * Send the push
     *
     * @param PushNotification $push Push
     * @return \Dec\Push\Collection\PushResult
     */
    public function push(PushNotification $push)
    {
        $push->setStatus(PushNotification::STATUS_SENDING);

        $devices = $push->getDevices()->chunk(100);

        $responses = [];

        foreach ($devices as $chunk)
        {
            $response = $this->sendBatch($chunk, $push->getMessage());

            $responses[] = $response;
        }

        $push->setStatus(PushNotification::STATUS_SENT);

        return new PushResponseCollection($push, $responses);
    }

    /**
     * @param \Dec\Push\Collection\DeviceCollection $devices
     * @param Message $message
     * @return \Dec\Push\Gcm\GcmResponse
     */
    protected function sendBatch(DeviceCollection $devices, Message $message)
    {
        $body = array_merge($message->getBody(), [
            'registration_ids'  => $devices->getTokens()
        ]);

        try {
            $response = $this->client->post(self::URL, [
                'headers' => [
                    'Authorization' => 'key=' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($body)
            ]);

            return GcmResponse::fromJson(
                $devices,
                $message,
                $response->getStatusCode(),
                $response->json()
            );
        } catch (RequestException $e) {
            throw $e;
        }
    }

    /**
     * Check if valid token
     *
     * @param $token
     * @return boolean
     */
    public function isValidToken($token)
    {
        return (bool) preg_match('/[0-9a-zA-Z\-\_]/i', $token);
    }

    /**
     * Get default config.
     *
     * @return array
     */
    public function getDefaultConfig()
    {
        return [];
    }

    /**
     * Get required config parameters.
     *
     * @return array
     */
    public function getRequiredConfig()
    {
        return ['api_key'];
    }

}