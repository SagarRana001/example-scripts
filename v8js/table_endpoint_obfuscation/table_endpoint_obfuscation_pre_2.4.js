var api_path = 'db/_table/todo'; //the service/_table/tablename you wish to obfuscate
var method = event.request.method;  //get the HTTP Method
var parameters = event.request.parameters; //copy params from the request to a var
var result; //create the result var (to be returned by the script)

if (event.resource && event.resource !== '') { //if there are additional resources in the request path add them to our request path
    api_path = api_path + '/' + event.resource;
}

if (event.request.payload) { //if the payload is not empty assign it to the payload var
    var payload = event.request.payload;
} else { //else make the payload null
    var payload = null;
}

if (Object.keys(parameters).length > 0) { //checks to see if the parameters object is not empty
    api_path = api_path + '?'; //adds the parameters back in to the api call.
    for (var property in parameters) {
        api_path = api_path + property + '=' + parameters[property] + '&';
    }
}

switch (method) { //Cases used to determine which verb to use when making our api call
    case 'GET':
        result = platform.api.get(api_path, payload);
        break;
    case 'POST':
        result = platform.api.post(api_path, payload);
        break;
    case 'PUT':
        result = platform.api.put(api_path, payload);
        break;
    case 'PATCH':
        result = platform.api.patch(api_path, payload);
        break;
    case 'DELETE':
        result = platform.api.delete(api_path, payload);
        break;
    default:
        result = {"message":"Cannot interpret this call. Invalid verb."};
        break;
}

return result; //return the data response to the client
