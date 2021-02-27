<?php

declare(strict_types=1);

/*
 * This file is part of the Picterest source code.
 *
 * (c) Julien Broyard <broyard.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
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
            throw new \TypeError('$count must be numeric.');
        }

        $none = $none ?? $plural;
        $string = ((0 === $count) ? $none : ((1 === $count) ? $singular : $plural));

        return sprintf($string, $count);
    }
}
