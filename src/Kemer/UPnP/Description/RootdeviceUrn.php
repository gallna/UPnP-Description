<?php
namespace Kemer\UPnP\Description;

/**
 * URN - Uniform Resource Name
 */
class RootdeviceUrn extends Urn
{
    /**
     * URN constructor
     *
     * @param string|bool $urn Uniform Resource Name
     */
    public function __construct()
    {
        $this->fromString('upnp:rootdevice');
    }

    /**
     * Create URN from string
     *
     * @param string $string
     *
     * @throws InvalidArgumentException
     * @return $this
     */
    public function fromString($urn)
    {
        if (!is_string($urn)) {
            throw new \InvalidArgumentException(
                sprintf('URN should be a string: "%s" given', gettype($urn))
            );
        }
        $this->setDomainName($urn);
        return $this;
    }

    /**
     * Return URN as string
     *
     * @return string
     */
    public function toString()
    {
        //upnp:rootdevice
        return $this->domainName;
    }
}
