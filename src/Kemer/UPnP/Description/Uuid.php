<?php
namespace Kemer\UPnP\Description;

/**
 *  UUID - Universally Unique Identifier
 *
 * Unique Device Name. Universally-unique identifier for the device, whether root or embedded.
 * Must be the same over time for a specific device instance (i.e., must survive reboots).
 * Must match the value of the NT header in device discovery messages. Must match the prefix
 * of the USN header in all discovery messages. (The section on Discovery explains the NT
 * and USN headers.) Must begin with uuid: followed by a UUID suffix specified by a UPnP vendor.
 * Single URI.
 */
class Uuid
{
    /**
     * Unique Device Name
     *
     * @var string
     */
    protected $name;

    /**
     * UUID constructor
     *
     * @param string $name Universally Unique Identifier
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns Universally Unique Identifier
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return UUID as string
     *
     * @return string
     */
    public function toString()
    {
        return sprintf("uuid:%s", $this->name);
    }

    /**
     * Return string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
