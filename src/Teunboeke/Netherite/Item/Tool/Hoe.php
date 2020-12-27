<?php

namespace Teunboeke\Netherite\Item\Tool;

use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;

class hoe extends TieredTool
{ 

     public function onAttackEntity(Entity $victim) : bool{
        return $this->applyDamage(1);
     }
     

  }
