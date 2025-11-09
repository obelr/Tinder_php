<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(title: 'HyperSwipe API', version: '1.0.0')]
#[OA\Server(url: 'http://localhost/api', description: 'Local')]
abstract class Controller
{
}
