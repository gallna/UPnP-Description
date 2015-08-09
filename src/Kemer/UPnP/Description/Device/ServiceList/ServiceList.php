<?php
namespace Kemer\UPnP\Description\Device\ServiceList;

class ServiceList implements \IteratorAggregate
{
    private $url;
    protected $services = [];

    public function __construct(array $services = [])
    {
        if (!empty($services)) {
            $this->fromArray($services);
        }
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function fromArray(array $services = [])
    {
        foreach ($services as $service) {
            $this->add(new Service($service));
        }
    }

    public function add(Service $service)
    {
        $this->services[$service->getUsn()->getUrn()->toString()] = $service;
    }

    public function get($serviceType)
    {
        return isset($this->services[$serviceType]) ? $this->services[$serviceType] : null;
    }

    public function filter(\Closure $callback)
    {
        return array_filter($this->services, $callback);
    }

    public function map(\Closure $callback)
    {
        return array_map($callback, $this->services);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->services);
    }

    public function toXml($dom)
    {
        $root = $dom->createElement('serviceList');
        foreach ($this->services as $service) {
            $root->appendChild(
                $child = $dom->createElement('service')
            );
            $child->appendChild(
                $dom->createElement("serviceType", $service->getServiceType())
            );
            $child->appendChild(
                $dom->createElement("serviceId", $service->getServiceId())
            );
            $child->appendChild(
                $dom->createElement("SCPDURL", $service->getSCPDURL())
            );
            $child->appendChild(
                $dom->createElement("controlURL", $service->getControlURL())
            );
            $child->appendChild(
                $dom->createElement("eventSubURL", $service->getEventSubURL())
            );
        }
        return $root;
    }
}

?>
