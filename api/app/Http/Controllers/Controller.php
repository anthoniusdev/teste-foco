<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost:8000/api"),
 * @OA\Info(title="API FocoMultimida", version="1.0.0")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
