<?php
namespace Kemer\UPnP\Description;

/**
 *  USN - Unique Service Name
 *
 * Identifies a unique instance of a device or service. Must be one of the following.
 *
 * uuid:device-UUID (for root device UUID)
 * uuid:device-UUID::upnp:rootdevice
 * uuid:device-UUID::urn:schemas-upnp-org:device:deviceType:v
 * uuid:device-UUID::urn:schemas-upnp-org:service:serviceType:v
 * uuid:device-UUID::urn:domain-name:device:deviceType:v
 * uuid:device-UUID::urn:domain-name:service:serviceType:v
 *
 * The prefix (before the double colon) must match the value of the UDN element in
 * the device description. Single URI.
 */
class Usn
{
    /**
     * Universally Unique Identifier
     *
     * @var Uuid
     */
    protected $uuid;

    /**
     * Uniform Resource Name
     *
     * @var Urn
     */
    protected $urn;

    /**
     * UDN constructor
     *
     * @param string $name Unique Device Name
     */
    public function __construct(Uuid $deviceUuid, $urn = null)
    {
        $this->setUuid($deviceUuid);
        $this->urn = $urn;
    }

    /**
     * Set UUID - Universally Unique Identifier
     *
     * @param string|Uuid $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        if (is_string($uuid)) {
            $uuid = new Uuid($uuid);
        }
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * Return UUID
     *
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set URN - Uniform Resource Name
     *
     * @param string|Urn $urn
     * @return $this
     */
    public function setUrn($urn)
    {
        if (is_string($urn)) {
            $urn = new Urn($urn);
        }
        $this->urn = $urn;
        return $this;
    }

    /**
     * Return URN
     *
     * @return Urn
     */
    public function getUrn()
    {
        return $this->urn;
    }

    /**
     * Return USN as string
     * i.e. uuid:UUID::urn:schemas-upnp-org:service:serviceType:v
     *
     * @return string
     */
    public function toString()
    {
        return sprintf("uuid:%s::%s", $this->uuid->getName(), $this->urn->toString());
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
