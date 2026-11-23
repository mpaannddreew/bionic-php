<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests;

use Andre\Bionic\Bionic;

/**
 * A Bionic instance that remembers every event it emits, in order
 */
class RecordingBionic extends Bionic
{
    /**
     * @var array<int, array{0: string, 1: array<int, mixed>}>
     */
    public array $emitted = [];

    public function emit($event, array $arguments = [])
    {
        $this->emitted[] = [$event, $arguments];

        parent::emit($event, $arguments);
    }

    /**
     * Names of the emitted events, in order
     *
     * @return string[]
     */
    public function eventNames(): array
    {
        return array_map(fn ($emitted) => $emitted[0], $this->emitted);
    }

    /**
     * Arguments of the first emission of $event, or null if it never fired
     *
     * @return array<int, mixed>|null
     */
    public function argumentsOf(string $event): ?array
    {
        foreach ($this->emitted as [$name, $arguments]) {
            if ($name === $event) {
                return $arguments;
            }
        }

        return null;
    }
}
