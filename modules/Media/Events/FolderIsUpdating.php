<?php

namespace Modules\Media\Events;

use Modules\Mon\Auth\Contracts\EntityIsChanging;
use Modules\Mon\Events\AbstractEntityHook;

class FolderIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
}
