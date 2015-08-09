<?php
namespace Kemer\UPnP\Description\Device;

use Kemer\UPnP\Description\Uuid;
use Kemer\UPnP\Description\Urn;
use Kemer\UPnP\Description\Usn;
use Zend\Uri\Http as HttpUri;

class DeviceDescription
{
    /**
     * USN - Unique Service Name
     * Container for UUID - Universally Unique Identifier and URN - Uniform Resource Name
     *
     * @var Usn
     */
    protected $usn;

    /**
     * URL for UPnP description for root device
     *
     * @var HttpUri
     */
    protected $location;

    /**
     * Concatenation of OS name, OS version, UPnP/1.0, product name, and product version.
     *
     * @var string
     */
    protected $server;

    /**
     * Service list
     *
     * @var ServiceList
     */
    protected $serviceList;

    /**
     * Icon list
     *
     * @var IconList
     */
    protected $iconList;

    /**
     * Other device description parameters
     *
     * @var array
     */
    private $description = [];

    /**
     * DeviceDescription constructor
     *
     * @param HttpUri $location
     * @param Usn $usn
     */
    public function __construct(HttpUri $location, Usn $usn = null)
    {
        $this->location = $location;
        $this->usn = $usn ?: new Usn();
        $this->serviceList = new ServiceList\ServiceList();
        $this->iconList = new IconList\IconList();
    }

    /**
     * Returns URL for UPnP description for root device
     *
     * @return HttpUri
     */
    public function getLocation()
    {
        return $this->location;
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
        $this->getUsn()->setUuid($uuid);
        return $this;
    }

    /**
     * Return UUID
     *
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->getUsn()->getUuid();
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
        $this->getUsn()->setUrn($urn);
        return $this;
    }

    /**
     * Return URN
     *
     * @return Urn
     */
    public function getUrn()
    {
        return $this->getUsn()->getUrn();
    }

    /**
     * Concatenation of OS name, OS version, UPnP/1.0, product name, and product version.
     * Specified by UPnP vendor. String. Must accurately reflect the version number of
     * the UPnP Device Architecture supported by the device. Control points must be prepared
     * to accept a higher version number than the control point itself implements.
     * For example, control points implementing UDA version 1.0 will be able to interoperate
     * with devices implementing UDA version 1.1.
     *
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * Returns concatenation of OS name, OS version, UPnP/1.0, product name, and product version.
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    public function fromXml($xml)
    {
        return $this->fromArray(
            (array)json_decode(json_encode(simplexml_load_string($xml)), true)
        );
    }

    public function fromArray(array $description)
    {
        //$this->iconList = isset($description["iconList"]) ? $description["iconList"] : null;
        if (isset($description["serviceList"]["service"])) {
            $this->serviceList->fromArray($description["serviceList"]);
            unset($description["serviceList"]);
        }
        $this->description = $description;
    }

    public function toXml()
    {
        $dom = new \DOMDocument("1.0");
        $dom->formatOutput = true;
        $root = $dom->createElementNS('urn:schemas-upnp-org:device-1-0', "root");
        $dom->appendChild($root);
        $root->appendChild($specVersion = $dom->createElement('specVersion'));
        $specVersion->appendChild($dom->createElement('major', 1));
        $specVersion->appendChild($dom->createElement('minor', 0));
        $root->appendChild($device = $dom->createElement('device'));

        $device->appendChild($dom->createElement('deviceType', (string)$this->getUrn()));
        $device->appendChild($dom->createElement('UDN', (string)$this->getUuid()));
        foreach ($this->description as $name => $value) {
            $device->appendChild($dom->createElement($name, $value));
        }
        $device->appendChild($this->serviceList->toXml($dom));
        $device->appendChild($this->iconList->toXml($dom));


        return $dom->saveXML();
    }

    public function setIconList(IconList\IconList $iconList)
    {
        $this->iconList = $iconList;
        return $this;
    }

    public function addIcon(IconList\Icon $icon)
    {
        $this->iconList->add($icon);
        return $this;
    }

    public function getIconList()
    {
        return $this->iconList;
    }

    public function setServiceList(ServiceList\ServiceList $serviceList)
    {
        $this->serviceList = $serviceList;
        return $this;
    }

    public function addService(ServiceList\Service $service)
    {
        $this->serviceList->add($service);
        return $this;
    }

    public function getServiceList()
    {
        return $this->serviceList;
    }

    public function __get($name)
    {
        return $this->description[$name];
    }

    public function __set($name, $parameter)
    {
        $this->description[$name] = $parameter;
    }

    public function __call($method, $params = null)
    {
        $key = strtolower(substr($method, 3));
        if($prefix = substr($method, 0, 3) == 'set') {
            $this->description[$key] = (count($params) == 1) ? $params[0] : $params;
        } elseif($prefix == 'get') {
            if(array_key_exists($key, $this->description)) {
                return $this->description[$key];
            }
            return null;
        } else {
            throw new \Exception('Opps! The method is not defined!');
        }
    }
}

?>
