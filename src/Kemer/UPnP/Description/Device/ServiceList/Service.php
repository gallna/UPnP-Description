<?php
namespace Kemer\UPnP\Description\Device\ServiceList;

use Kemer\UPnP\Description\Usn;
use Kemer\UPnP\Description\Urn;

class Service
{
    /**
     * USN - Unique Service Name
     * Container for UUID - Universally Unique Identifier and URN - Uniform Resource Name
     *
     * @var Usn
     */
    protected $usn;

    /**
     * URL for service description
     * @var string
     */
    private $sCPDURL;

    /**
     * URL for control
     * @var string
     */
    private $controlURL;

    /**
     * URL for eventing
     * @var string
     */
    private $eventSubURL;

    public function __construct(Usn $usn)
    {
        $this->usn = $usn;
    }

    /**
     * Return USN - Unique Service Name
     *
     * @return Usn
     */
    public function getUsn()
    {
        return $this->usn;
    }

    /**
     * Return URN - Uniform Resource Name
     *
     * @return Urn
     */
    public function getUrn()
    {
        return $this->getUsn()->getUrn();
    }

    public function getServiceType()
    {
        return $this->getUsn()->getUrn()->toString();
    }

    public function getServiceId()
    {
        $urn = $this->getUsn()->getUrn();
        return sprintf(
            'urn:upnp-org:serviceId:%s:%s',
            $urn->getServiceType(),
            $urn->getVersion()
        );
    }

    public function setSCPDURL($sCPDURL)
    {
        $this->sCPDURL = $sCPDURL;
        return $this;
    }

    public function getSCPDURL()
    {
        return $this->sCPDURL;
    }

    public function setControlURL($controlURL)
    {
        $this->controlURL = $controlURL;
        return $this;
    }

    public function getControlURL()
    {
        return $this->controlURL;
    }

    public function setEventSubURL($eventSubURL)
    {
        $this->eventSubURL = $eventSubURL;
        return $this;
    }

    public function getEventSubURL()
    {
        return $this->eventSubURL;
    }

    public function toXml()
    {
        if ($this->getServiceType() == Urn::CONTENT_DIRECTORY) {
            return file_get_contents(dirname(dirname(__DIR__))."/Service/xml/ContentDirectory1.xml");
        }
        if ($this->getServiceType() == Urn::CONNECTION_MANAGER) {
            return file_get_contents(dirname(dirname(__DIR__))."/Service/xml/ConnectionManager1.xml");
        }
    }
}

?>
