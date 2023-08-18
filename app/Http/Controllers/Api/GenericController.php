<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller as Controller;


class GenericController extends Controller
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */
    public function sendResponse($message, $result)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    /**
    * return error response.
    *
    * @return \Illuminate\Http\Response
    */
    public function sendError($error, $errorMessages = [], 
        $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'data'=> '',
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
