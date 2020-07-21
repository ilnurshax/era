<?php


namespace Ilnurshax\Era\Support\Money;


class Money
{

    /**
     * @var int
     */
    private $cents;

    /**************************************************************************
     *
     * Creation
     *
     **************************************************************************/

    public static function createFromDollars(?float $dollars)
    {
        if ($dollars === null) {
            $dollars = .0;
        }

        return new static((int)round($dollars * 100)); // Fix bug
    }

    public static function createFromCents(?int $cents)
    {
        return new static($cents ?? 0);
    }

    public function __construct(int $cents = 0)
    {
        $this->cents = $cents;
    }

    /**************************************************************************
     *
     * Casts
     *
     **************************************************************************/

    public function __toString()
    {
        return '$' . $this->asDollars();
    }

    public function asCents(): int
    {
        return $this->cents;
    }

    public function asDollars(): float
    {
        return $this->cents / 100;
    }

    /**************************************************************************
     *
     * Conditions
     *
     **************************************************************************/

    public function gt(Money $money): bool
    {
        return $this->asCents() > $money->asCents();
    }

    public function gte(Money $money): bool
    {
        return $this->asCents() >= $money->asCents();
    }

    public function eq(Money $money): bool
    {
        return $this->asCents() == $money->asCents();
    }

    public function lt(Money $money): bool
    {
        return $this->asCents() < $money->asCents();
    }

    public function ne(Money $money): bool
    {
        return !$this->eq($money);
    }

    public function eqZero(): bool
    {
        return $this->asCents() == 0;
    }

    public function gtZero(): bool
    {
        return $this->asCents() > 0;
    }

    public function ltZero(): bool
    {
        return $this->asCents() < 0;
    }

    public function lteZero(): bool
    {
        return $this->asCents() <= 0;
    }

    /**************************************************************************
     *
     * Operations
     *
     **************************************************************************/

    public function invert(): Money
    {
        return new static($this->asCents() * -1);
    }

    public function abs(): Money
    {
        return new static(abs($this->asCents()));
    }

    public function sub(Money $money): Money
    {
        return static::createFromCents($this->asCents() - $money->asCents());
    }

    public function add(Money $money)
    {
        return static::createFromCents($this->asCents() + $money->asCents());
    }

    public function percents(float $percents)
    {
        return static::createFromCents($this->asCents() * $percents * 0.01);
    }
}
