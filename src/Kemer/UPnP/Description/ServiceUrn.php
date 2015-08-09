<?php
namespace Kemer\UPnP\Description;

/**
 * URN - Uniform Resource Name
 */
class ServiceUrn extends Urn
{
    /**
     * ServiceUrn constructor
     *
     * @param string $serviceType
     */
    public function __construct($serviceType)
    {
        $services = [
            Urn::CONTENT_DIRECTORY,
            Urn::RENDERING_CONTROL,
            Urn::CONNECTION_MANAGER,
            Urn::AV_TRANSPORT
        ];
        if (!in_array($serviceType, $services)) {
            throw new InvalidArgumentException("Invalid service type $serviceType");
        }
        $this->setServiceType($serviceType);
    }
}
