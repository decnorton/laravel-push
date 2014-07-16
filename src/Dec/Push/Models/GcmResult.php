<?php namespace Dec\Push\Models;

class GcmResult {

    /**
     * @var string
     */
    private $messageId;

    /**
     * @var string
     */
    private $registrationId;

    /**
     * @var string
     */
    private $error;

    function __construct($messageId, $registrationId, $error)
    {
        $this->error = $error;
        $this->messageId = $messageId;
        $this->registrationId = $registrationId;
    }

    public function successful()
    {
        return ! $this->error;
    }

    public function failed()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param mixed $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }


} 