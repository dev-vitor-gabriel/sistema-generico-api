<?php

namespace App\Http\Controllers;

use App\Enums\OrigemStatusEnum;
use App\Models\Status;

class StatusController extends Controller
{
    public function getByOrigem(int $origem)
    {
        return Status::getByOrigem($origem);
    }
}
