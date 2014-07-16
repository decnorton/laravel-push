<?php namespace Dec\Push\Gcm;

use Dec\Push\Collection\DeviceCollection;
use Dec\Push\Gcm\Exceptions\GcmAuthenticationException;
use Dec\Push\Gcm\Exceptions\GcmInvalidJsonBody;
use Dec\Push\Gcm\Exceptions\GcmServerException;
use Dec\Push\Models\BasePushResponse;
use Dec\Push\Models\Message;
use Illuminate\Support\Collection;

class GcmResponse extends BasePushResponse {

    /**
     * @var bool
     */
    private $id;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var int
     */
    private $successCount;

    /**
     * @var int
     */
    private $failureCount;

    /**
     * @var int
     */
    private $canonicalCount;

    /**
     * @var array
     */
    private $results;

    function __construct(DeviceCollection $devices, Message $message, $statusCode, $id, $canonicalIds, $successfulMessages, $failedMessages, $results)
    {

        // Throw exceptions for critical errors
        switch ($statusCode)
        {
            case 200:
                // No error!
                break;

            case 400:
                throw new GcmInvalidJsonBody($statusCode, $message->getBody());

            case 401:
                throw new GcmAuthenticationException();

            case 500:
                throw new GcmServerException($statusCode);
        }

        parent::__construct($devices, $message);

        $this->id = $id;
        $this->statusCode = (int) $statusCode;
        $this->canonicalCount = (int) $canonicalIds;
        $this->successCount = (int) $successfulMessages;
        $this->failureCount = (int) $failedMessages;
        $this->results = $results;
    }

    public static function fromJson(DeviceCollection $devices, Message $message, $statusCode, $json)
    {
        return new GcmResponse(
            $devices,
            $message,
            $statusCode,
            $json['multicast_id'],
            $json['canonical_ids'],
            $json['success'],
            $json['failure'],
            $json['results']
        );
    }

    /**
     * @return bool
     */
    public function success()
    {
        return $this->statusCode == 200;
    }

    /**
     * @return bool
     */
    public function failed()
    {
        return $this->statusCode != 200;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailureCount()
    {
        return $this->failureCount;
    }

    public function getCanonicalCount()
    {
        return $this->canonicalCount;
    }

    public function getFailed()
    {
        $out = [];

        foreach ($this->results as $index => $result)
        {
            if (isset($result['error']))
                $out[] = new GcmResult($this->devices[$index], $result);
        }

        return new Collection($out);
    }

    public function getSuccessful()
    {
        $out = [];

        foreach ($this->results as $key => $value)
        {
            if ( ! isset($value['error']))
                $out[] = $value;
        }

        return $out;
    }

    public function toArray()
    {
        return [
            'multicast_id' => $this->id,
            'status_code' => $this->statusCode,
            'success_count' => $this->successCount,
            'failure_count' => $this->failureCount,
            'canonical_count' => $this->canonicalCount,
            'message' => $this->message->getBody(),
            'failed' => $this->getFailed()
        ];
    }

} 