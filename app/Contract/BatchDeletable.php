<?php

namespace App\Contract;

interface BatchDeletable
{
    public static function deleteAssociatedRecords(string $column, array $records): void;
}
