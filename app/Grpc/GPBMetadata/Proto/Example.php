<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/example.proto

namespace GPBMetadata\Proto;

class Example
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
proto/example.protoexample"
HelloRequest
name (	" 
HelloResponse
message (	2M
ExampleService;
sayHello.example.HelloRequest.example.HelloResponse" bproto3'
        , true);

        static::$is_initialized = true;
    }
}

