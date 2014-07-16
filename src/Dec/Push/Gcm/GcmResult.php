<?php namespace Dec\Push\Gcm;


use Dec\Push\Devices\Device;
use Illuminate\Support\Contracts\ArrayableInterface;

class GcmResult implements ArrayableInterface {

    const ERROR_MISSING_REGISTRATION = 'MissingRegistration';
    const ERROR_INVALID_REGISTRATION = 'InvalidRegistration';
    const ERROR_SENDER_ID = 'MismatchSenderId';
    const ERROR_NOT_REGISTERED = 'NotRegistered';
    const ERROR_MESSAGE_TOO_BIG = 'MessageTooBig';
    const ERROR_INVALID_DATA_KEY = 'InvalidDataKey';
    const ERROR_INVALID_TTL = 'InvalidTtl';
    const ERROR_UNAVAILABLE = 'Unavailable';
    const ERROR_SERVER = 'InternalServerError';
    const ERROR_INVALID_PACKAGE_NAME = 'InvalidPackageName';

    /**
     * @var Device
     */
    protected $device;

    /**
     * @var array
     */
    protected $result;

    /**
     * String describing the error
     * @var string
     */
    protected $error;

    /**
     * String representing the message when it was successfully processed
     * @var string
     */
    protected $messageId;

    /**
     * If set, you should update the device's token
     * @var string
     */
    protected $registrationId;

    function __construct(Device $device, $result)
    {
        $this->device = $device;
        $this->result = $result;

        $this->messageId        = isset($result['message_id'])      ? $result['message_id'] : null;
        $this->registrationId   = isset($result['registration_id']) ? $result['registration_id'] : null;
        $this->error            = isset($result['error'])           ? $result['error'] : null;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'device' => $this->device->getToken(),
            'result' => $this->result
        ];
    }

} 