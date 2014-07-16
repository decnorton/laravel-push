<?php namespace Dec\Push\Adapters;

use Dec\Collection\DeviceCollection;
use Dec\Push\Models\GcmMessage;
use Dec\Push\Models\GcmResponse;
use Dec\Push\Models\MessageInterface;
use Dec\Push\Models\Push;
use Dec\Push\Models\PushInterface;
use Dec\Push\Models\PushResult;
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
     * @param MessageInterface $message
     * @return PushInterface
     */
    public function createPush(DeviceCollection $devices, MessageInterface $message)
    {
        return new Push($devices, $message);
    }

    /**
     * Send the push
     *
     * @param PushInterface $push Push
     * @return PushResult
     */
    public function push(PushInterface $push)
    {
        $push->setStatus(PushInterface::STATUS_SENDING);

        $tokens = array_chunk($push->getDevices(), 100);

        $responses = [];
        $successful = [];
        $failed = [];

        foreach ($tokens as $devices)
        {
            $response = $this->sendPush($devices, $push->getMessage());
            $successful = array_merge($successful, $response->getSuccessfulResults());
            $failed = array_merge($failed, $response->getFailedResults());

            $responses[] = $response;
        }

        $push->setStatus(PushInterface::STATUS_SENT);

        return new PushResult($responses, $successful, $failed);
    }

    /**
     * @param DeviceCollection $devices
     * @param GcmMessage $message
     * @return GcmResponse
     */
    protected function sendPush(DeviceCollection $devices, GcmMessage $message)
    {
        $body = array_merge($message->getParameters(), [
            'data'              => $message->getContent(),
            'registration_ids'  => $devices->getTokens()
        ]);

        $response = $this->client->post(self::URL, [
            'headers' => [
                'Authorization' => 'key=' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'body' => json_encode($body)
        ]);

        $json = json_encode($response->getBody());

        return GcmResponse::fromJson($response->getStatusCode(), $json);
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