<?php namespace Dec\Push\Gcm;


use Dec\Push\Models\BaseMessage;

class GcmMessage extends BaseMessage {

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->getParameter('collapse_key');
    }

    /**
     * @param string $collapseKey
     */
    public function setCollapseKey($collapseKey)
    {
        $this->setParameter('collapse_key', $collapseKey);
    }

    /**
     * @return bool
     */
    public function getDelayWhileIdle()
    {
        return $this->getParameter('delay_while_idle');
    }

    /**
     * @param bool $delayWhileIdle
     */
    public function setDelayWhileIdle($delayWhileIdle)
    {
        $this->setParameter('delay_while_idle', $delayWhileIdle);
    }

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->getParameter('ttl');
    }

    /**
     * @param int $ttl
     */
    public function setTtl($ttl)
    {
        $this->setParameter('ttl', $ttl);
    }

    /**
     * Returns the request body
     * @return array
     */
    public function getBody()
    {
        return array_merge($this->getParameters(), [
            'data' => $this->getContent()
        ]);
    }

} 