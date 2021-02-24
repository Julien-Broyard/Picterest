<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('pluralize', [$this, 'getPluralizedString']),
        ];
    }

    public function getPluralizedString(int $count, string $singular, string $plural, ?string $none = null): string
    {
        if (!is_numeric($count)) {
            throw new \Exception('$count must be numeric.');
        }

        $none = $none ?? $plural;
        $string = (($count === 0) ? $none : (($count === 1) ? $singular : $plural));

        return sprintf($string, $count);
    }
}
