<?php

namespace OurRichLife;

interface ValueObject
{
    public function value(): mixed;

    public static function fromNative(mixed $value): ValueObject;

    public function toNative(): mixed;

    public function isNull(): bool;
}
