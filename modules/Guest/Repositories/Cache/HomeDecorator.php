<?php

namespace Modules\Guest\Repositories\Cache;

use Modules\Guest\Repositories\HomeRepository;
use Modules\Olavui\Repositories\Cache\BaseCacheDecorator;

class HomeDecorator extends BaseCacheDecorator implements HomeRepository
{
    public function __construct(HomeRepository $home)
    {
        parent::__construct();
        $this->entityName = 'guest.homes';
        $this->repository = $home;
    }
}
