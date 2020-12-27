<?php

namespace Teunboeke\blocks;

class BlockWeightedPressurePlateHeavy extends BlockPressurePlateBase {

    protected $id = self::HEAVY_WEIGHTED_PRESSURE_PLATE;
    
    public function getName() : string {
        return "Heavy Weighted Pressure Plate";
    }

    public function computeDamage() : int {
        $count = count($this->level->getNearbyEntities($this->bb()));
        $count += 9;
        if ($count > 150) {
            $count = 150;
        }
        return floor($count / 10);
    }

    public function getDelay() : int {
        return 8;
    }

    public function getOnSoundExtraData() : int {
        return 829;
    }

    public function getOffSoundExtraData() : int {
        return 1525;
    }

    public function getStrongPower(int $face) : int {
        if (!$this->isPowerSource()) {
            return 0;
        }
        if ($face == Facing::UP) {
            return $this->getDamage();
        }
        return 0;
    }

    public function getWeakPower(int $face) : int {
        if (!$this->isPowerSource()) {
            return 0;
        }
        return $this->getDamage();
    }
}

<?php

namespace redstone\blocks;

class BlockWeightedPressurePlateLight extends BlockPressurePlateBase {

    protected $id = self::LIGHT_WEIGHTED_PRESSURE_PLATE;
    
    public function getName() : string {
        return "Light Weighted Pressure Plate";
    }

    public function computeDamage() : int {
        $count = count($this->level->getNearbyEntities($this->bb()));
        if ($count > 15) {
            $count = 15;
        }
        return $count;
    }

    public function getDelay() : int {
        return 8;
    }

    public function getOnSoundExtraData() : int {
        return 1004;
    }

    public function getOffSoundExtraData() : int {
        return 3379;
    }

    public function getStrongPower(int $face) : int {
        if (!$this->isPowerSource()) {
            return 0;
        }
        if ($face == Facing::UP) {
            return $this->getDamage();
        }
        return 0;
    }

    public function getWeakPower(int $face) : int {
        if (!$this->isPowerSource()) {
            return 0;
        }
        return $this->getDamage();
    }
}

<?php

namespace Teunboeke\blocks;

use pocketmine\block\BlockFactory;
use pocketmine\block\WoodenDoor;

use pocketmine\level\sound\DoorSound;

use pocketmine\math\Vector3;


use redstone\utils\Facing;

class BlockWoodenDoor extends WoodenDoor implements IRedstone {

    use RedstoneTrait;
    
    public function getStrongPower(int $face) : int {
        return 0;
    }

    public function getWeakPower(int $face) : int {
        return 0;
    }

    public function isPowerSource() : bool {
        return false;
    }

    public function onRedstoneUpdate() : void {
        if (($this->getDamage() & 0x08) === 0x08) {
            $up = $this;
            $down = $this->getSide(Facing::DOWN);
        } else {
            $up = $this->getSide(Facing::UP);
            $down = $this;
        }

        if ($this->isBlockPowered($up->asVector3()) || $this->isBlockPowered($down->asVector3())) {
            if (($up->getDamage() & 0x02) != 0x02 && ($down->getDamage() & 0x04) != 0x04) {
                $up->setDamage($up->getDamage() ^ 0x02);
                $down->setDamage($down->getDamage() ^ 0x04);
                $this->level->addSound(new DoorSound($this));
            } elseif (($up->getDamage() & 0x02) != 0x02) {
                $up->setDamage($up->getDamage() ^ 0x02);
            }
        } else {
            if (($up->getDamage() & 0x02) == 0x02 && ($down->getDamage() & 0x04) == 0x04) {
                $up->setDamage($up->getDamage() ^ 0x02);
                $down->setDamage($down->getDamage() ^ 0x04);
                $this->level->addSound(new DoorSound($this));
            }
        }

        $this->level->setBlock($up, $up, true);
        $this->level->setBlock($down, $down, true);
    }
}
