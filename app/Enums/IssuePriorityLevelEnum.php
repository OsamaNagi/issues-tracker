<?php

namespace App\Enums;

enum IssuePriorityLevelEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';
}
