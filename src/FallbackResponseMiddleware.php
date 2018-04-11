<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher\Relay;

use Interop\Http\Factory\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FallbackResponseMiddleware implements MiddlewareInterface
{
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $this->responseFactory->createResponse(404);
    }
}
