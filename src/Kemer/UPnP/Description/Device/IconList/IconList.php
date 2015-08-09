<?php
namespace Kemer\UPnP\Description\Device\IconList;

class IconList extends \ArrayObject
{

    public function __construct(array $icon = [])
    {
        foreach ($icon as $icon) {
            $this->add($icon);
        }
    }

    public function add(Icon $icon)
    {
        $this->icons[] = $icon;
    }


    public function all()
    {
        return $this->icons;
    }

    public function toXml($dom)
    {
        $root = $dom->createElement('iconList');
        foreach ($this->icons as $icon) {
            $root->appendChild(
                $child = $dom->createElement('icon')
            );
            $child->appendChild(
                $dom->createElement("mimetype", $icon->getMimetype())
            );
            $child->appendChild(
                $dom->createElement("width", $icon->getWidth())
            );
            $child->appendChild(
                $dom->createElement("height", $icon->getHeight())
            );
            $child->appendChild(
                $dom->createElement("depth", $icon->getDepth())
            );
            $child->appendChild(
                $dom->createElement("url", $icon->getUrl())
            );
        }
        return $root;
    }
}

?>
