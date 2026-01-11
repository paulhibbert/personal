<?php

namespace App\ValueObjects;

final class YearPrefixedString
{
    private string $raw;
    private int $year;
    private string $content;

    private function __construct(string $raw, int $year, string $content)
    {
        $this->raw = $raw;
        $this->year = $year;
        $this->content = $content;
    }

    public static function tryFrom(string $value): ?self
    {
        if (! preg_match('/^(?<year>\d{4}):(?<content>.*)$/', $value, $matches)) {
            return null;
        }

        $year = (int) $matches['year'];

        if ($year <= 1939) {
            return null;
        }

        return new self(
            raw: $value,
            year: $year,
            content: ltrim($matches['content'])
        );
    }

    public function year(): int
    {
        return $this->year;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function raw(): string
    {
        return $this->raw;
    }

    public function __toString(): string
    {
        return $this->raw;
    }
}
