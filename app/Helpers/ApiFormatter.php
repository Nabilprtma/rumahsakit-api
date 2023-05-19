<?php
// fungsi file ini untuk mengatur hasil API tang akan ditampilkan

// file ini mengatur proses pengambilan API
// namespace : mengatur posisi file ada di folder mana 
namespace App\Helpers;

class ApiFormatter{
    // variable yang akan dihasilkan ketika api digunakan)
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    public static function createAPI($code = NULL, $message = NULL, $data = NULL)
    {
        // mengisi data ke variable $response yang diatas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        // mengembalikan hasil pengisian data $response dengan format json
        return response()->json(self::$response, self::$response['code']);
    }
}
?>