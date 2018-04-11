<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher\Relay;

use Polus\MiddlewareDispatcher\AbstractDispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;

class Dispatcher extends AbstractDispatcher
{
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $middlewares = $this->middlewares->toArray();
        $middlewares[] = new FallbackResponseMiddleware($this->responseFactory);

        $relay = new Relay($middlewares);
        return  $relay->handle($request);
    }

}
