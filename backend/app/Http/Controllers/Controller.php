<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(title: 'HyperSwipe API', version: '1.0.0')]
#[OA\Server(url: 'https://tinderphp-production.up.railway.app/api', description: 'Production')]
abstract class Controller
{
}
