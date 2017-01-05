<?php

//This section sets up the platform object with shortcuts to each verb
$api = $platform['api'];
$get = $api->get;
$post = $api->post;
$put = $api->put;
$patch = $api->patch;
$delete = $api->delete;

$api_path = 'db/_table/todo'; //the service/_table/tablename you wish to obfuscate
$method = $event['request']['method']; //get the HTTP Method
$options['parameters'] = $event['request']['parameters']; //copy params from the request to the options object

if ( $event['resource'] && $event['resource'] != '' ) { //if there are additional resources in the request path add them to our request path
  $api_path = $api_path . '/' . $event['resource'];
}

if ( $event['request']['payload'] ) { //if the payload is not empty assign it to the payload var
  $payload = $event['request']['payload'];
} else { //else make the payload null
  $payload = null;
}

switch ( $method ) { //Cases used to determine which verb to use when making our api call
  case 'GET':
    $result = $get ( $api_path, $payload, $options );
    break;
  case 'POST':
    $result = $post ( $api_path, $payload, $options );
    break;
  case 'PUT':
    $result = $put ( $api_path, $payload, $options );
    break;
  case 'PATCH':
    $result = $patch ( $api_path, $payload, $options );
    break;
  case 'DELETE':
    $result = $delete ( $api_path, $payload, $options );
    break;
  default:
    $result['message'] = 'Cannot interpret this call. Invalid verb.';
    break;
}

return $result; //return the data response to the client

?>
