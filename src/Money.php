<?php declare(strict_types=1);

namespace OurRichLife;


use InvalidArgumentException;

final readonly class Money implements ValueObject
{
    public function __construct(private ?int $value = null)
    {
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public static function fromNative(mixed $value): ValueObject
    {
        $value = match (true) {
            is_string($value) || is_float($value) => (int)round(floatval($value) * 100),
            is_int($value) => $value * 100,
            is_null($value) => null,
            default => throw new InvalidArgumentException(sprintf('%s is not a valid number', $fromNative)),
        };
        return new Money($value);
    }

    public function equal(Money $money): bool
    {
        return $money->value() === $this->value;
    }

    public function add(Money $money): Money
    {
        return new Money($this->value + $money->value());
    }

    public function sub(Money $money): Money
    {
        return new Money($this->value - $money->value());
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

    public function format(?string $currency = null, int $decimals = 2, string $decimalSeparator = ','): string
    {
        $value = number_format($this->toNative(), $decimals, $decimalSeparator, ' ');
        return match (true) {
            ! is_null($currency) => sprintf('%s %s', $currency, $value),
            default => $value,
        };
    }
}
