<?php
namespace Kemer\UPnP\Description;

class Discovery
{
    protected $cacheControl;
    protected $location;
    protected $server;
    protected $st;
    protected $usn;

    public function __construct(array $spec)
    {
        $this->fromArray($spec);
    }

    public function fromArray(array $spec)
    {
        $this->cacheControl = isset($spec['cache-control']) ? $spec['cache-control'] : null;
        $this->location = isset($spec['location']) ? $spec['location'] : null;
        $this->server = isset($spec['server']) ? $spec['server'] : null;
        $this->st = isset($spec['st']) ? $spec['st'] : null;
        $this->usn = isset($spec['usn']) ? $spec['usn'] : null;
    }

    public function setCacheControl($cacheControl)
    {
        $this->cacheControl = $cacheControl;
    }

    public function getCacheControl()
    {
        return $this->cacheControl;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setSt($st)
    {
        $this->st = $st;
    }

    public function getSt()
    {
        return $this->st;
    }

    public function setUsn($usn)
    {
        $this->usn = $usn;
    }

    public function getUsn()
    {
        return $this->usn;
    }

    public function getUrl()
    {
        $url = parse_url($this->getLocation());
        return $url['scheme'].'://'.$url['host'].':'.$url['port'];
    }
}
