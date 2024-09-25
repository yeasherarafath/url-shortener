<?php

namespace App\Trait;

trait RepoResponse
{
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;


    function successReponse($message,  $data = null, $des = null, $status = 1, $code = 200){

        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'description' => $des
        ]);

    }

    public function errorResponse($message, $data = null, $des = null, $status = 0, $code = 400)
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'description' => $des
        ],$code);
    }

}
