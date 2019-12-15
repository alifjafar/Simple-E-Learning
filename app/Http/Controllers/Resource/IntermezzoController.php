<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;

class IntermezzoController extends Controller
{
    public function __invoke()
    {
        $response = $this->ApiGET('intermezzo/today');

        return $response;
    }
}
