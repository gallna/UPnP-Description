<?php
namespace Kemer\UPnP\Description;

/**
 * URN - Uniform Resource Name
 */
class Urn
{
    const MEDIA_SERVER = "urn:schemas-upnp-org:device:MediaServer:1";
    const MEDIA_RENDERER = "urn:schemas-upnp-org:device:MediaRenderer:1";

    const CONTENT_DIRECTORY = "urn:schemas-upnp-org:service:ContentDirectory:1";
    const RENDERING_CONTROL = "urn:schemas-upnp-org:service:RenderingControl:1";
    const CONNECTION_MANAGER = "urn:schemas-upnp-org:service:ConnectionManager:1";
    const AV_TRANSPORT = "urn:schemas-upnp-org:service:AVTransport:1";
    /**
     * UPnP Forum working committee type
     */
    const UPNP_DOMAIN_NAME = 'schemas-upnp-org';

    /**
     * UPnP Version 1
     */
    const UPNP_VERSION_1 = 1;

    /**
     * UPnP Version
     *
     * @var string
     */
    protected $version = Urn::UPNP_VERSION_1;

    /**
     * Domain name
     *
     * @var string
     */
    protected $domainName = Urn::UPNP_DOMAIN_NAME;

    /**
     * Device type
     *
     * @var string
     */
    protected $deviceType;

    /**
     * Service type
     *
     * @var string
     */
    protected $serviceType;

    /**
     * URN constructor
     *
     * @param string|bool $urn Uniform Resource Name
     */
    public function __construct($urn = null)
    {
        if (is_string($urn)) {
            $this->fromString($urn);
        }
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
        $chunks = explode(":", $urn);
        if (count($chunks) != 5) {
            throw new \InvalidArgumentException(sprintf('Invalid URN: %s', $urn));
        }
        array_shift($chunks);
        $this->setDomainName(array_shift($chunks));
        switch ($type = array_shift($chunks)) {
            case "device":
                $this->setDeviceType(array_shift($chunks));
                break;
            case "service":
                $this->setServiceType(array_shift($chunks));
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid URN type: %s', $type));
        }
        $this->setVersion(array_shift($chunks));
        return $this;
    }

    /**
     * Set UPnP Version
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Returns UPnP Version
     *
     * @param string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set domain name
     *
     * @param string $domainName
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;
        return $this;
    }

    /**
     * Returns domain name
     *
     * @param string
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * Set device type
     *
     * @param string $deviceType
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    /**
     * Returns device type
     *
     * @param string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Set service type
     *
     * @param string $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
        return $this;
    }

    /**
     * Returns service type
     *
     * @param string
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * Return URN as string
     *
     * @return string
     */
    public function toString()
    {
        //urn:schemas-upnp-org:device:MediaServer:1
        return sprintf(
            'urn:%s:%s:%s:%s',
            $this->domainName,
            $this->deviceType ? 'device' : 'service',
            $this->deviceType ?: $this->serviceType,
            $this->version
        );
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
