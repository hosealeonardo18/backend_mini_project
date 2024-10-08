<?php

if (!function_exists('handleResponse')) {
    function handleResponse($result, $error, $statusCode, $message, $pagination = null)
    {
        $resultPrint = [
            "error" => $error,
            "status_code" => $statusCode,
            "message" => $message ?? null,
            "data" => $result,
            "pagination" => $pagination
        ];

        return response()->json($resultPrint, $statusCode);
    }
}

if (!function_exists('handleErrorException')) {
    function handleErrorException($e)
    {
        $message = $e->getMessage();  // Mendapatkan pesan kesalahan dari pengecualian

        // Default status code
        $statusCode = $e->getCode();

        // Jika pengecualian adalah TypeError
        if ($e instanceof \TypeError) {
            $message = "Internal Server Error";
        } else if ($statusCode == 0 || $statusCode > 600) {
            $statusCode = 500;
        }

        return response()->json(['error' => true, 'statusCode' =>  $statusCode, 'message' => $message], $statusCode);
    }
}

if (!function_exists('getUid')) {
    function getUid()
    {
        $bytes = random_bytes(10);
        $base64 = base64_encode($bytes);
        return rtrim(strtr($base64, '+/', '-_'), '=');
    }
}
