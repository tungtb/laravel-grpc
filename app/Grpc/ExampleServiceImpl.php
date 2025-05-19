<?php
namespace App\Grpc;

use Example\ExampleServiceInterface;
use Example\HelloRequest;
use Example\HelloResponse;
use Spiral\RoadRunner\GRPC;

class ExampleServiceImpl implements ExampleServiceInterface
{
    /**
    * @param GRPC\ContextInterface $ctx
    * @param HelloRequest $in
    * @return HelloResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function sayHello(GRPC\ContextInterface $ctx, HelloRequest $in): HelloResponse
    {
        $name = $in->getName();
        $response = new HelloResponse();
        $response->setMessage("Hello, $name!");
        return $response;
    }
}
