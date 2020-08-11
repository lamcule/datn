<?php

namespace Modules\Media\Events;

use Modules\Mon\Auth\Contracts\EntityIsChanging;
use Modules\Mon\Events\AbstractEntityHook;

final class FileIsCreating extends AbstractEntityHook implements EntityIsChanging
{
}
