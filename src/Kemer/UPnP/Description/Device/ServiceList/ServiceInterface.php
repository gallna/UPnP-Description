<?php
namespace Kemer\UPnP\Description\Device\ServiceList;

interface ServiceInterface
{
    public function getServiceType();
    public function getServiceId();
    public function getSCPDURL();
    public function getControlURL();
    public function getEventSubURL();
}

?>
