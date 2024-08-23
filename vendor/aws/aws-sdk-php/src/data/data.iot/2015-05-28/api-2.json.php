<?php
// This file was auto-generated from sdk-root/src/data/data.iot/2015-05-28/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2015-05-28', 'endpointPrefix' => 'data-ats.iot', 'protocol' => 'rest-json', 'serviceFullName' => 'AWS IoT Data Plane', 'serviceId' => 'IoT Data Plane', 'signatureVersion' => 'v4', 'signingName' => 'iotdata', 'uid' => 'iot-data-2015-05-28', ], 'operations' => [ 'DeleteThingShadow' => [ 'name' => 'DeleteThingShadow', 'http' => [ 'method' => 'DELETE', 'requestUri' => '/things/{thingName}/shadow', ], 'input' => [ 'shape' => 'DeleteThingShadowRequest', ], 'output' => [ 'shape' => 'DeleteThingShadowResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], [ 'shape' => 'UnsupportedDocumentEncodingException', ], ], ], 'GetRetainedMessage' => [ 'name' => 'GetRetainedMessage', 'http' => [ 'method' => 'GET', 'requestUri' => '/retainedMessage/{topic}', ], 'input' => [ 'shape' => 'GetRetainedMessageRequest', ], 'output' => [ 'shape' => 'GetRetainedMessageResponse', ], 'errors' => [ [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], ], ], 'GetThingShadow' => [ 'name' => 'GetThingShadow', 'http' => [ 'method' => 'GET', 'requestUri' => '/things/{thingName}/shadow', ], 'input' => [ 'shape' => 'GetThingShadowRequest', ], 'output' => [ 'shape' => 'GetThingShadowResponse', ], 'errors' => [ [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], [ 'shape' => 'UnsupportedDocumentEncodingException', ], ], ], 'ListNamedShadowsForThing' => [ 'name' => 'ListNamedShadowsForThing', 'http' => [ 'method' => 'GET', 'requestUri' => '/api/things/shadow/ListNamedShadowsForThing/{thingName}', ], 'input' => [ 'shape' => 'ListNamedShadowsForThingRequest', ], 'output' => [ 'shape' => 'ListNamedShadowsForThingResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], ], ], 'ListRetainedMessages' => [ 'name' => 'ListRetainedMessages', 'http' => [ 'method' => 'GET', 'requestUri' => '/retainedMessage', ], 'input' => [ 'shape' => 'ListRetainedMessagesRequest', ], 'output' => [ 'shape' => 'ListRetainedMessagesResponse', ], 'errors' => [ [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], ], ], 'Publish' => [ 'name' => 'Publish', 'http' => [ 'method' => 'POST', 'requestUri' => '/topics/{topic}', ], 'input' => [ 'shape' => 'PublishRequest', ], 'errors' => [ [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'MethodNotAllowedException', ], ], ], 'UpdateThingShadow' => [ 'name' => 'UpdateThingShadow', 'http' => [ 'method' => 'POST', 'requestUri' => '/things/{thingName}/shadow', ], 'input' => [ 'shape' => 'UpdateThingShadowRequest', ], 'output' => [ 'shape' => 'UpdateThingShadowResponse', ], 'errors' => [ [ 'shape' => 'ConflictException', ], [ 'shape' => 'RequestEntityTooLargeException', ], [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'UnauthorizedException', ], [ 'shape' => 'ServiceUnavailableException', ], [ 'shape' => 'InternalFailureException', ], [ 'shape' => 'MethodNotAllowedException', ], [ 'shape' => 'UnsupportedDocumentEncodingException', ], ], ], ], 'shapes' => [ 'ConflictException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 409, ], 'exception' => true, ], 'DeleteThingShadowRequest' => [ 'type' => 'structure', 'required' => [ 'thingName', ], 'members' => [ 'thingName' => [ 'shape' => 'ThingName', 'location' => 'uri', 'locationName' => 'thingName', ], 'shadowName' => [ 'shape' => 'ShadowName', 'location' => 'querystring', 'locationName' => 'name', ], ], ], 'DeleteThingShadowResponse' => [ 'type' => 'structure', 'required' => [ 'payload', ], 'members' => [ 'payload' => [ 'shape' => 'JsonDocument', ], ], 'payload' => 'payload', ], 'GetRetainedMessageRequest' => [ 'type' => 'structure', 'required' => [ 'topic', ], 'members' => [ 'topic' => [ 'shape' => 'Topic', 'location' => 'uri', 'locationName' => 'topic', ], ], ], 'GetRetainedMessageResponse' => [ 'type' => 'structure', 'members' => [ 'topic' => [ 'shape' => 'Topic', ], 'payload' => [ 'shape' => 'Payload', ], 'qos' => [ 'shape' => 'Qos', ], 'lastModifiedTime' => [ 'shape' => 'Timestamp', ], ], ], 'GetThingShadowRequest' => [ 'type' => 'structure', 'required' => [ 'thingName', ], 'members' => [ 'thingName' => [ 'shape' => 'ThingName', 'location' => 'uri', 'locationName' => 'thingName', ], 'shadowName' => [ 'shape' => 'ShadowName', 'location' => 'querystring', 'locationName' => 'name', ], ], ], 'GetThingShadowResponse' => [ 'type' => 'structure', 'members' => [ 'payload' => [ 'shape' => 'JsonDocument', ], ], 'payload' => 'payload', ], 'InternalFailureException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 500, ], 'exception' => true, 'fault' => true, ], 'InvalidRequestException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 400, ], 'exception' => true, ], 'JsonDocument' => [ 'type' => 'blob', ], 'ListNamedShadowsForThingRequest' => [ 'type' => 'structure', 'required' => [ 'thingName', ], 'members' => [ 'thingName' => [ 'shape' => 'ThingName', 'location' => 'uri', 'locationName' => 'thingName', ], 'nextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'nextToken', ], 'pageSize' => [ 'shape' => 'PageSize', 'location' => 'querystring', 'locationName' => 'pageSize', ], ], ], 'ListNamedShadowsForThingResponse' => [ 'type' => 'structure', 'members' => [ 'results' => [ 'shape' => 'NamedShadowList', ], 'nextToken' => [ 'shape' => 'NextToken', ], 'timestamp' => [ 'shape' => 'Timestamp', ], ], ], 'ListRetainedMessagesRequest' => [ 'type' => 'structure', 'members' => [ 'nextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'nextToken', ], 'maxResults' => [ 'shape' => 'MaxResults', 'location' => 'querystring', 'locationName' => 'maxResults', ], ], ], 'ListRetainedMessagesResponse' => [ 'type' => 'structure', 'members' => [ 'retainedTopics' => [ 'shape' => 'RetainedMessageList', ], 'nextToken' => [ 'shape' => 'NextToken', ], ], ], 'MaxResults' => [ 'type' => 'integer', 'max' => 200, 'min' => 1, ], 'MethodNotAllowedException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 405, ], 'exception' => true, ], 'NamedShadowList' => [ 'type' => 'list', 'member' => [ 'shape' => 'ShadowName', ], ], 'NextToken' => [ 'type' => 'string', ], 'PageSize' => [ 'type' => 'integer', 'max' => 100, 'min' => 1, ], 'Payload' => [ 'type' => 'blob', ], 'PayloadSize' => [ 'type' => 'long', ], 'PublishRequest' => [ 'type' => 'structure', 'required' => [ 'topic', ], 'members' => [ 'topic' => [ 'shape' => 'Topic', 'location' => 'uri', 'locationName' => 'topic', ], 'qos' => [ 'shape' => 'Qos', 'location' => 'querystring', 'locationName' => 'qos', ], 'retain' => [ 'shape' => 'Retain', 'location' => 'querystring', 'locationName' => 'retain', ], 'payload' => [ 'shape' => 'Payload', ], ], 'payload' => 'payload', ], 'Qos' => [ 'type' => 'integer', 'max' => 1, 'min' => 0, ], 'RequestEntityTooLargeException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 413, ], 'exception' => true, ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 404, ], 'exception' => true, ], 'Retain' => [ 'type' => 'boolean', ], 'RetainedMessageList' => [ 'type' => 'list', 'member' => [ 'shape' => 'RetainedMessageSummary', ], ], 'RetainedMessageSummary' => [ 'type' => 'structure', 'members' => [ 'topic' => [ 'shape' => 'Topic', ], 'payloadSize' => [ 'shape' => 'PayloadSize', ], 'qos' => [ 'shape' => 'Qos', ], 'lastModifiedTime' => [ 'shape' => 'Timestamp', ], ], ], 'ServiceUnavailableException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 503, ], 'exception' => true, 'fault' => true, ], 'ShadowName' => [ 'type' => 'string', 'max' => 64, 'min' => 1, 'pattern' => '[a-zA-Z0-9:_-]+', ], 'ThingName' => [ 'type' => 'string', 'max' => 128, 'min' => 1, 'pattern' => '[a-zA-Z0-9:_-]+', ], 'ThrottlingException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 429, ], 'exception' => true, ], 'Timestamp' => [ 'type' => 'long', ], 'Topic' => [ 'type' => 'string', ], 'UnauthorizedException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 401, ], 'exception' => true, ], 'UnsupportedDocumentEncodingException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'errorMessage', ], ], 'error' => [ 'httpStatusCode' => 415, ], 'exception' => true, ], 'UpdateThingShadowRequest' => [ 'type' => 'structure', 'required' => [ 'thingName', 'payload', ], 'members' => [ 'thingName' => [ 'shape' => 'ThingName', 'location' => 'uri', 'locationName' => 'thingName', ], 'shadowName' => [ 'shape' => 'ShadowName', 'location' => 'querystring', 'locationName' => 'name', ], 'payload' => [ 'shape' => 'JsonDocument', ], ], 'payload' => 'payload', ], 'UpdateThingShadowResponse' => [ 'type' => 'structure', 'members' => [ 'payload' => [ 'shape' => 'JsonDocument', ], ], 'payload' => 'payload', ], 'errorMessage' => [ 'type' => 'string', ], ],];
