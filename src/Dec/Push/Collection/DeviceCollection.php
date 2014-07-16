<?php namespace Dec\Collection;

use Dec\Push\Models\DeviceInterface;
use Illuminate\Support\Collection;

class DeviceCollection extends Collection {

    function __construct(array $devices = [])
    {
        // Make sure we're getting an array of DeviceInterfaces
        foreach ($devices as $device)
        {
            if ( ! is_a($device, 'DeviceInterface'))
                throw new \InvalidArgumentException('Array must contain only DeviceInterfaces');
        }

        parent::__construct();
    }


    /**
     * Add a device to the collection
     *
     * @param DeviceInterface $device
     */
    public function add(DeviceInterface $device)
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
            $tokens[] = $device->getToken();
        }

        return array_unique(array_filter($tokens));
    }

} 