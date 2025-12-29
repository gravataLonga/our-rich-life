<?php declare(strict_types=1);

namespace OurRichLife;


use InvalidArgumentException;

final class Money implements ValueObject
{
    private ?int $value;

    public function __construct(mixed $fromNative)
    {
        $this->value = match (true) {
            is_string($fromNative) || is_float($fromNative) => (int)(floatval($fromNative) * 100),
            is_int($fromNative) => $fromNative * 100,
            is_null($fromNative) => null,
            default => throw new InvalidArgumentException(sprintf('%s is not a valid number', $fromNative)),
        };
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public static function fromNative(mixed $value): ValueObject
    {
        return new Money($value);
    }

    public function toNative(): mixed
    {
        return match (true) {
            $this->isNull() => null,
            default => $this->value / 100
        };
    }

    public function isNull(): bool
    {
        return $this->value === null;
    }
}
