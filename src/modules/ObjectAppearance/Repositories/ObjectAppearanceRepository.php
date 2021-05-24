<?php

namespace Modules\ObjectAppearance\Repositories;

use Modules\ObjectAppearance\Models\ObjectAppearance;
use Infrastructure\BaseRepository;

class ObjectAppearanceRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(ObjectAppearance::class);
    }
}
