<?php

namespace App\Helpers;

//use Kreait\Firebase\Messaging\CloudMessage;

class SendMessage
{

    public static $successStatus = 200;

    public static function success($message_id, $data, $message)
    {
        return response()->json([
            'status' => 1,
            'message_id' => $message_id,
            'message' => $message,
            'data' => $data,
        ], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public static function error($message_id, $data, $message)
    {
        return response()->json([
            'status' => -1,
            'message_id' => $message_id,
            'message' => $message,
            'data' => $data,
        ], SendMessage::$successStatus,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

//
//    public static function SendFCM($body, $token)
//    {
//        $messaging = app('firebase.messaging');
//        $message = CloudMessage::withTarget('token', $token)
//            ->withData([
//                'title' => __('home.new_msg'),
//                'body' => $body]);
//
//        try {
//            $messaging->send($message);
//        } catch (\Exception $e) {
//            \Log::info($e);
//        }
//
//    }

}
