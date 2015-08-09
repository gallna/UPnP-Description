<?php
namespace Kemer\UPnP\Description;

interface Device
{
    const ALL = "ssdp:all";
    const ROOT_DEVICE = "upnp:rootdevice";
    const MEDIA_SERVER = "urn:schemas-upnp-org:device:MediaServer:1";
    const MEDIA_RENDERER = "urn:schemas-upnp-org:device:MediaRenderer:1";
}
