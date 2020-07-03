<?php

declare(strict_types=1);

namespace deceitya\TxtParticle;

use pocketmine\level\Level;
use pocketmine\scheduler\Task;

class KeepShowingParticlesTask extends Task
{
    /** @var array */
    private $particles = [];
    /** @var Level */
    private $level;

    public function __construct(array $particles, Level $level)
    {
        $this->particles = $particles;
        $this->level = $level;
    }

    public function onRun(int $currentTick)
    {
        foreach ($this->particles as $particle) {
            $this->level->addParticle($particle);
        }
    }
}
