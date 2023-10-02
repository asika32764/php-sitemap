<?php

declare(strict_types=1);

namespace Asika\Sitemap;

/**
 * The ChangeFreq.
 */
enum ChangeFreq: string
{
    case ALWAYS = 'always';
    case HOURLY = 'hourly';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case NEVER = 'never';
}
