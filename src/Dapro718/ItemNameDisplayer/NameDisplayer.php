<?php

declare(strict_types=1);

namespace Dapro718\ItemNameDisplayer;

use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\utils\Config;
use Dapro718\ItemNameDisplayer\Main;

class NameDisplayer implements Listener {
  
  public $config;
  public $plugin;
  
  public function __construct(Main $plugin) {
    $this->plugin = $plugin;
    $this->config = $plugin->getConfig();
  }
  
  public function onItemDrop(ItemSpawnEvent $event) {
    $entity = $event->getEntity();
    $lvl = $entity->getLevel();
    $level = $lvl->getName();
    $item = $entity->getItem();
    $id = $item->getId();
    $disabledWorlds = $this->config->get("disabled-worlds");
    $disabledItems = $this->config->get("disabled-items");
    $name = $item->getName();
    $fcon = $this->config->get("display-format");
    echo("$entity entity\n");
    echo("$level level\n");
    echo("$item item\n");
    echo("$id id\n");
    echo("$name name\n");
    echo("$fcon format\n");
    if(in_array($level, $disabledWorlds, TRUE)) {
      $event->setCancelled();
      echo("world");
      if(in_array($id, $disabledItems, TRUE)) {
        $event->setCancelled();
        echo("ids");
      } else {
        $format = str_replace("{name}", $name, $fcon);
        echo("$format format");
        $entity->setNameTag($format);
        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
      }
    }
  }
}
