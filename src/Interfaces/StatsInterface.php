<?php

namespace StatsPHP\Interfaces;

interface StatsInterface
{
    public function incrementStats(): void;

    public function decrementStats(): void;

    public function getStats(): array;
}
