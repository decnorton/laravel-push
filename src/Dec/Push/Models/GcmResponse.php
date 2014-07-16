<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 15/07/2014
 * Time: 21:33
 */

namespace Dec\Models;


class GcmResponse implements PushResponse {

    /**
     * @var bool
     */
    private $id;
    private $statusCode;
    private $successCount;
    private $failureCount;
    private $canonicalCount;
    private $results;

    function __construct($statusCode, $id, $canonicalIds, $successfulMessages, $failedMessages, $results)
    {
        $this->statusCode = $statusCode;
        $this->id = $id;
        $this->canonicalCount = $canonicalIds;
        $this->successCount = (int) $successfulMessages;
        $this->failureCount = (int) $failedMessages;
        $this->results = $results;
    }

    public static function fromJson($statusCode, $json)
    {
        return new GcmResponse(
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

    public function getFailedResults()
    {
        $out = [];

        foreach ($this->results as $key => $value)
        {
            if (isset($value['error']))
                $out[] = $value;
        }

        return $out;
    }

    public function getSuccessfulResults()
    {
        $out = [];

        foreach ($this->results as $key => $value)
        {
            if ( ! isset($value['error']))
                $out[] = $value;
        }

        return $out;
    }

} 