<?php

namespace Teunboeke;

use pocketmine\plugin\PluginBase;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;

use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemFactory;

use pocketmine\tile\Tile;

use Teunboeke\blockEntities\BlockEntityCommandBlock;
use Teunboeke\blockEntities\BlockEntityDispenser;
use Teunboeke\blockEntities\BlockEntityDropper;
use Teunboeke\blockEntities\BlockEntityHopper;
use Teunboeke\blockEntities\BlockEntityNoteBlock;
use Teunboeke\blockEntities\BlockEntityObserver;
use Teunboeke\blockEntities\BlockEntityPistonArm;
use Teunboeke\blockEntities\BlockEntityRedstoneComparator;

use Teunboeke\blocks\BlockButtonStone;
use Teunboeke\blocks\BlockButtonWooden;
use Teunboeke\blocks\BlockCommand;
use Teunboeke\blocks\BlockCommandChain;
use Teunboeke\blocks\BlockCommandRepeating;
use Teunboeke\blocks\BlockDispenser;
use Teunboeke\blocks\BlockDropper;
use Teunboeke\blocks\BlockFenceGate;
use Teunboeke\blocks\BlockHopper;
use Teunboeke\blocks\BlockIronDoor;
use Teunboeke\blocks\BlockIronTrapdoor;
use Teunboeke\blocks\BlockLever;
use Teunboeke\blocks\BlockNote;
use Teunboeke\blocks\BlockObserver;
use Teunboeke\blocks\BlockPiston;
use Teunboeke\blocks\BlockPressurePlateStone;
use Teunboeke\blocks\BlockPressurePlateWooden;
use Teunboeke\blocks\BlockRedstone;
use Teunboeke\blocks\BlockRedstoneComparatorPowered;
use Teunboeke\blocks\BlockRedstoneComparatorUnpowered;
use Teunboeke\blocks\BlockRedstoneLamp;
use Teunboeke\blocks\BlockRedstoneLampLit;
use Teunboeke\blocks\BlockRedstoneRepeaterPowered;
use Teunboeke\blocks\BlockRedstoneRepeaterUnpowered;
use Teunboeke\blocks\BlockRedstoneTorch;
use Teunboeke\blocks\BlockRedstoneTorchUnlit;
use Teunboeke\blocks\BlockRedstoneWire;
use Teunboeke\blocks\BlockTNT;
use Teunboeke\blocks\BlockTrapdoor;
use Teunboeke\blocks\BlockWeightedPressurePlateLight;
use Teunboeke\blocks\BlockWeightedPressurePlateHeavy;
use Teunboeke\blocks\BlockWoodenDoor;

use Teunboeke\listeners\EventListener;
use Teunboeke\listeners\ScheduledBlockUpdateListener;

use Teunboeke\utils\ScheduledBlockUpdateLoader;

class Main extends PluginBase {

    private static $instance;

    public static function getInstance() : Main {
        return Main::$instance;
    }

    private $scheduledBlockUpdateLoader;

    public function onEnable() {
        Main::$instance = $this;

        $this->scheduledBlockUpdateLoader = new ScheduledBlockUpdateLoader();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $this->initBlocks();
        $this->initBlockEntities();
        $this->initItems();
        $this->initCreativeItem();
    }

    public function onDisable() {
        if (!$this->scheduledBlockUpdateLoader->isActivate()) {
            return;
        }

        foreach($this->getServer()->getLevels() as $level){
            $this->scheduledBlockUpdateLoader->saveLevel($level);
        }
    }

    public function getScheduledBlockUpdateLoader() : ScheduledBlockUpdateLoader {
        return $this->scheduledBlockUpdateLoader;
    }

    private function initBlocks() : void {
        BlockFactory::registerBlock(new BlockRedstoneWire(), true);

        BlockFactory::registerBlock(new BlockRedstoneTorch(), true);
        BlockFactory::registerBlock(new BlockRedstoneTorchUnlit(), true);

        BlockFactory::registerBlock(new BlockRedstoneRepeaterPowered(), true);
        BlockFactory::registerBlock(new BlockRedstoneRepeaterUnpowered(), true);

        BlockFactory::registerBlock(new BlockRedstoneComparatorPowered(), true);
        BlockFactory::registerBlock(new BlockRedstoneComparatorUnpowered(), true);

        BlockFactory::registerBlock(new BlockObserver(), true);


        BlockFactory::registerBlock(new BlockRedstone(), true);

        BlockFactory::registerBlock(new BlockLever(), true);

        BlockFactory::registerBlock(new BlockButtonStone(), true);
        BlockFactory::registerBlock(new BlockButtonWooden(), true);

        BlockFactory::registerBlock(new BlockPressurePlateStone(), true);
        BlockFactory::registerBlock(new BlockPressurePlateWooden(), true);
        BlockFactory::registerBlock(new BlockWeightedPressurePlateLight(), true);
        BlockFactory::registerBlock(new BlockWeightedPressurePlateHeavy(), true);


        BlockFactory::registerBlock(new BlockRedstoneLamp(), true);
        BlockFactory::registerBlock(new BlockRedstoneLampLit(), true);

        BlockFactory::registerBlock(new BlockNote(), true);

        BlockFactory::registerBlock(new BlockDropper(), true);
        BlockFactory::registerBlock(new BlockDispenser(), true);

        BlockFactory::registerBlock(new BlockHopper(), true);

        //BlockFactory::registerBlock(new BlockPiston(), true);

        BlockFactory::registerBlock(new BlockCommand(), true);
        BlockFactory::registerBlock(new BlockCommandRepeating(), true);
        BlockFactory::registerBlock(new BlockCommandChain(), true);

        BlockFactory::registerBlock(new BlockTNT(), true);

        BlockFactory::registerBlock(new BlockWoodenDoor(Block::OAK_DOOR_BLOCK, 0, "Oak Door", Item::OAK_DOOR), true);
        BlockFactory::registerBlock(new BlockWoodenDoor(Block::SPRUCE_DOOR_BLOCK, 0, "Spruce Door", Item::SPRUCE_DOOR), true);
        BlockFactory::registerBlock(new BlockWoodenDoor(Block::BIRCH_DOOR_BLOCK, 0, "Birch Door", Item::BIRCH_DOOR), true);
        BlockFactory::registerBlock(new BlockWoodenDoor(Block::JUNGLE_DOOR_BLOCK, 0, "Jungle Door", Item::JUNGLE_DOOR), true);
        BlockFactory::registerBlock(new BlockWoodenDoor(Block::ACACIA_DOOR_BLOCK, 0, "Acacia Door", Item::ACACIA_DOOR), true);
        BlockFactory::registerBlock(new BlockWoodenDoor(Block::DARK_OAK_DOOR_BLOCK, 0, "Dark Oak Door", Item::DARK_OAK_DOOR), true);

        BlockFactory::registerBlock(new BlockIronDoor(), true);

        BlockFactory::registerBlock(new BlockTrapdoor(), true);
        BlockFactory::registerBlock(new BlockIronTrapdoor(), true);
        
        BlockFactory::registerBlock(new BlockFenceGate(Block::OAK_FENCE_GATE, 0, "Oak Fence Gate"), true);
        BlockFactory::registerBlock(new BlockFenceGate(Block::SPRUCE_FENCE_GATE, 0, "Spruce Fence Gate"), true);
        BlockFactory::registerBlock(new BlockFenceGate(Block::BIRCH_FENCE_GATE, 0, "Birch Fence Gate"), true);
        BlockFactory::registerBlock(new BlockFenceGate(Block::JUNGLE_FENCE_GATE, 0, "Jungle Fence Gate"), true);
        BlockFactory::registerBlock(new BlockFenceGate(Block::DARK_OAK_FENCE_GATE, 0, "Dark Oak Fence Gate"), true);
        BlockFactory::registerBlock(new BlockFenceGate(Block::ACACIA_FENCE_GATE, 0, "Acacia Fence Gate"), true);
    }

    private function initBlockEntities() : void {
        Tile::registerTile(BlockEntityCommandBlock::class, ["CommandBlock", "minecraft:command_block"]);
        Tile::registerTile(BlockEntityDropper::class, ["Dropper", "minecraft:dropper"]);
        Tile::registerTile(BlockEntityDispenser::class, ["Dispenser", "minecraft:dispenser"]);
        Tile::registerTile(BlockEntityHopper::class, ["Hopper", "minecraft:hopper"]);
        Tile::registerTile(BlockEntityNoteBlock::class, ["NoteBlock", "minecraft:note_block"]);
        Tile::registerTile(BlockEntityObserver::class, ["Observer", "minecraft:observer"]);
        Tile::registerTile(BlockEntityRedstoneComparator::class, ["Comparator", "minecraft:comparator"]);
        //Tile::registerTile(BlockEntityPistonArm::class, ["PistonArm", "minecraft:piston_arm"]);
    }

    private function initItems() : void {
        ItemFactory::registerItem(new ItemBlock(Block::UNPOWERED_REPEATER, 0, Item::REPEATER), true);
        ItemFactory::registerItem(new ItemBlock(Block::UNPOWERED_COMPARATOR, 0, Item::COMPARATOR), true);
        ItemFactory::registerItem(new ItemBlock(Block::COMMAND_BLOCK, 0, Item::COMMAND_BLOCK), true);
        ItemFactory::registerItem(new ItemBlock(Block::DROPPER, 0, Item::DROPPER), true);
        ItemFactory::registerItem(new ItemBlock(Block::DISPENSER, 0, Item::DISPENSER), true);
        ItemFactory::registerItem(new ItemBlock(Block::OBSERVER, 0, Item::OBSERVER), true);
        //ItemFactory::registerItem(new ItemBlock(Block::PISTON, 0, Item::PISTON), true);
    }

    private function initCreativeItem() : void {
        Item::addCreativeItem(Item::get(Item::OBSERVER));
        Item::addCreativeItem(Item::get(Item::REPEATER));
        Item::addCreativeItem(Item::get(Item::COMPARATOR));
        Item::addCreativeItem(Item::get(Item::HOPPER));
        Item::addCreativeItem(Item::get(Item::COMMAND_BLOCK));
        Item::addCreativeItem(Item::get(Item::DROPPER));
        Item::addCreativeItem(Item::get(Item::DISPENSER));
        //Item::addCreativeItem(Item::get(Item::PISTON));
    }
}
