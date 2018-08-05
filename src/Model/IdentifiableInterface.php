<?php
declare(strict_types=1);

namespace App\Model;

interface IdentifiableInterface
{
    public static function getIdName();
}