<?php

namespace IsaEken\PluginSystem\Enums;

enum PluginState: string
{
    case Enabled = 'enabled';
    case Disabled = 'disabled';
    case Outdated = 'outdated';
}
