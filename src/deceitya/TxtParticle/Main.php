<?php

declare(strict_types=1);

namespace deceitya\TxtParticle;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\particle\FlameParticle;
use pocketmine\Player;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->saveResource('unko.txt');
    }

    public function onCommand(CommandSender $sender, Command $command, string $rabel, array $args): bool
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage('プレイヤーのみ実行できるコマンドです。');
            return true;
        }

        if (!isset($args[0])) {
            return false;
        }

        $file = null;
        try {
            $file = fopen("{$this->getDataFolder()}{$args[0]}.txt", 'r');
            if ($file !== false) {
                $z = 0;
                $particle = new FlameParticle($sender);
                while ($line = fgets($file)) {
                    $x = 0;
                    foreach (str_split($line) as $str) {
                        if ($str === '#') {
                            $particle->x = $x + $sender->x;
                            $particle->y = $sender->y + 1;
                            $particle->z = $z + $sender->z;
                            $sender->level->addParticle($particle);
                        }

                        $x += 0.3;
                    }

                    $z += 0.3;
                }
            }
        } catch (\Exception $e) {
            $sender->sendMessage("{$args[0]}.txt not found");
        } finally {
            if ($file !== null) {
                fclose($file);
            }
        }

        return true;
    }
}
