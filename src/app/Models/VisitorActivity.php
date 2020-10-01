<?php

namespace Baas\LaravelVisitorLogger\App\Models;

use Baas\LaravelVisitorLogger\App\Http\Traits\VisitorActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorActivity extends Model
{

    use SoftDeletes , VisitorActivityTrait;

}
