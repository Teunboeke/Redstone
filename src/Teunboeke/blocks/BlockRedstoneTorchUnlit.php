<?php

namespace  Teunboeke\blocks;

use Teunboeke\utils\Facing;

class BlockRedstoneTorchUnlit extends BlockRedstoneTorch {
    
    protected $id = self::UNLIT_REDSTONE_TORCH;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function getName() : string {
        return "Unlit Redstone Torch";
    }

    public function getLightLevel() : int {
        return 0;
    }

    public function onScheduledUpdate() : void {
        if (!$this->isSidePowered($this, $this->getFace())) {
            $this->getLevel()->setBlock($this, new BlockRedstoneTorch($this->getDamage()));
            $this->updateAroundDiodeRedstone($this);
        }
    }

    /**
     * @param int $face
     */
    public function getStrongPower(int $face) : int {
        return 0;
    }

    /**
     * @param int $face
     */
    public function getWeakPower(int $face) : int {
        return 0;
    }

    /** 
     * @return bool
     */
    public function isPowerSource() : bool {
        return false;
    }

    public function onRedstoneUpdate() : void {
        if (!$this->isSidePowered($this, $this->getFace())) {
            $this->level->scheduleDelayedBlockUpdate($this, 2);
        }
    }
}


        
