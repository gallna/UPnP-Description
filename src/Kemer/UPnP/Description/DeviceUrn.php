<?php
namespace Kemer\UPnP\Description;

/**
 * URN - Uniform Resource Name
 */
class DeviceUrn extends Urn
{
    /**
     * DeviceUrn constructor
     *
     * @param string $deviceType
     */
    public function __construct($deviceType)
    {
        if (!in_array($deviceType, [Urn::MEDIA_SERVER, Urn::MEDIA_RENDERER])) {
            throw new InvalidArgumentException("Invalid device type $deviceType");
        }
        $this->setDeviceType($deviceType);
    }
}
