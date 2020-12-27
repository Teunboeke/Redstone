<?php

namespace Teunboeke\listeners;

use pocketmine\event\Listener;

use pocketmine\event\level\LevelLoadEvent;
use pocketmine\event\level\LevelSaveEvent;

use Teunboeke\Main;

class scheduledBlockUpdateListener implements Listener {

    public function onLevelLoad(LevelLoadEvent $event) : void {
        Main::getInstance()->getScheduledBlockUpdateLoader()->loadLevel($event->getLevel());
    }

    public function onLevelSave(LevelSaveEvent $event) : void {
        Main::getInstance()->getScheduledBlockUpdateLoader()->saveLevel($event->getLevel());
    }
}
