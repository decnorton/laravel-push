<?php namespace Dec\Push\Collection;

use Config;
use Dec\Push\Devices\Device;
use Illuminate\Support\Collection;

class DeviceCollection extends Collection {

    /**
     * @param array $devices
     */
    function __construct(array $devices = [])
    {
        $devices = array_unique($devices);

        $deviceModelName = Config::get('push::device_model', 'SimpleDevice');

        // Make sure we're getting an array of DeviceInterfaces
        foreach ($devices as &$device)
        {
            if ($device instanceof Device || $device instanceof DeviceCollection)
                continue;

            if (is_string($device) || is_numeric($device))
                $device = $deviceModelName::withToken((string) $device);
            else
                throw new \InvalidArgumentException('Array must contain DeviceInterfaces or token strings');
        }

        parent::__construct($devices);
    }

    /**
     * Add a device to the collection
     *
     * @param Device $device
     */
    public function add(Device $device)
    {
        $this->items[] = $device;
    }

    /**
     * Get an array of all the device tokens
     * @return array
     */
    public function getTokens()
    {
        $tokens = [];

        foreach ($this as $device) {
            if ($device instanceof DeviceCollection)
            {
                $tokens = array_merge($tokens, $device->getTokens());
            }
            else if ($device instanceof Device)
            {
                $tokens[] = $device->getToken();
            }
        }

        return array_unique(array_filter($tokens));
    }

} 