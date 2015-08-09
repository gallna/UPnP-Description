<?php
use Zend\Uri\UriFactory;
use Kemer\UPnP\Description;
use Kemer\UPnP\Description\Urn;
use Kemer\UPnP\Description\Usn;
use Kemer\UPnP\Description\Uuid;
use Kemer\UPnP\Description\Device;
use Kemer\UPnP\Description\Discovery;
use Kemer\UPnP\Description\Device\IconList\Icon;

include_once '../vendor/autoload.php';

$serverIp = str_replace("\n","",shell_exec("ifconfig eth0 | grep 'inet addr' | awk -F':' {'print $2'} | awk -F' ' {'print $1'}"));
$serverPort = 10002;

$location = UriFactory::factory(sprintf("http://%s:%s/%s", $serverIp, $serverPort, 'dms/ddd.xml'));
$uuid = new Uuid(strtoupper('71205cf6-b918-41ff-a24e-802d73c0f187'));

$deviceDescription = new Device\DeviceDescription(
    $location,
    new Usn($uuid, new Urn(Urn::MEDIA_SERVER))
);

$deviceDescription->setServer("Linux/3.x, UPnP/1.0, Kemer/1.0");
$deviceDescription->fromArray([
    "friendlyName" => 'Kemer UPnP',
    "manufacturer" => "Tomasz Jonik",
    "manufacturerURL" => "https://github.com/gallna/UPnP-Description",
    "modelName" => 'Kemer UPnP',
    "modelDescription" => "UPnP 1.0 Server",
    "modelURL" => "https://github.com/gallna/UPnP-Description",
    "modelNumber" => "1.0.0",
    "serialNumber" => "1.2",
]);

$deviceDescription->addIcon($icon = new Icon([
    "mimetype" => "image/png",
    "width" => "32",
    "height" => "32",
    "depth" => "24",
    "url" => "/icons/icon_32.png",
]));
$deviceDescription->addIcon($icon = new Icon([
    "mimetype" => "image/png",
    "width" => "128",
    "height" => "128",
    "depth" => "24",
    "url" => "/icons/icon_128.png",
]));
$deviceDescription->addIcon($icon = new Icon([
    "mimetype" => "image/png",
    "width" => "512",
    "height" => "512",
    "depth" => "24",
    "url" => "/icons/icon_512.png",
]));

$service = new Device\ServiceList\Service(
    new Usn($uuid, new Urn(Urn::CONNECTION_MANAGER))
);
$service->setSCPDURL("/dms/sdd_1.xml")
    ->setControlURL("/connection-manager")
    ->setEventSubURL("/connection-manager-event");

$deviceDescription->addService($service);

$service = new Device\ServiceList\Service(
    new Usn($uuid, new Urn(Urn::CONTENT_DIRECTORY))
);
$service->setSCPDURL("/dms/sdd_0.xml")
    ->setControlURL("/content-directory")
    ->setEventSubURL("/content-directory-event");

$deviceDescription->addService($service);

$dom = new \DOMDocument("1.0");
$dom->formatOutput = true;
$dom->loadXML($deviceDescription->toXml());

echo "<pre>".htmlspecialchars($dom->saveXML())."</pre>";
