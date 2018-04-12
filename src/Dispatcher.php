<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher\Relay;

use Interop\Http\Factory\ResponseFactoryInterface;
use Polus\MiddlewareDispatcher\AbstractDispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;

class Dispatcher extends AbstractDispatcher
{
    /**
     * @var callable|null
     */
    private $relayResolver;

    public function __construct(ResponseFactoryInterface $responseFactory, ?callable $relayResolver = null)
    {
        parent::__construct($responseFactory);
        $this->relayResolver = $relayResolver;
    }

    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $middlewares = $this->middlewares->toArray();
        $middlewares[] = new FallbackResponseMiddleware($this->responseFactory);

        $relay = new Relay($middlewares, $this->relayResolver);
        return  $relay->handle($request);
    }

}
