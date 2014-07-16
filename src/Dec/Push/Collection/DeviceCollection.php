<?php namespace Dec\Collection;

use Dec\Push\Models\DeviceInterface;
use Illuminate\Support\Collection;

class DeviceCollection extends Collection {

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