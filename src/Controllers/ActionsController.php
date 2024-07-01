<?php

namespace ZapLite\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class ActionsController
{
    public function handleTrigger(Request $request)
    {
        $data = $request->toArray();
        $response = new Response(json_encode(['message' => 'Action handled', 'data' => $data]), 200, ['Content-Type' => 'application/json']);
    $response->send();
    }

    public function handleAction(Request $request)
    {
        $data = $request->toArray();
        $response = new Response(json_encode(['message' => 'Action handled', 'data' => $data]), 200, ['Content-Type' => 'application/json']);
        $response->send();
    }
}