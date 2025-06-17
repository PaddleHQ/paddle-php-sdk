<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;

interface SimulationConfigCreate extends \JsonSerializable
{
    public static function getScenarioType(): SimulationScenarioType;
}
