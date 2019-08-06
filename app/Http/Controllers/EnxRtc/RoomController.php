<?php

namespace App\Http\Controllers\EnxRtc;

use App\EnxRtc\Errors;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function curlOperations($options)
    {
        $ch = curl_init(config('app.enx_url') . "{$options['url']}");

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(config('app.enx_app_id') . ":" . config('app.enx_app_key')),
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, isset($options['headers']) ? $options['headers'] : $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, isset($options['type']) && $options['type'] === 'POST' ? true : false);

        if ($options['type'] && $options['type'] === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
        }

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function createRoom()
    {
        $random_name = rand(100000, 999999);
        /* Create Room Meta */
        $Room = array(
            "name" => "Sample Room: " . $random_name,
            "owner_ref" => $random_name,
            "settings" => array(
                "description" => "",
                "quality" => "HD",
                "mode" => "group",
                "participants" => "10",
                "duration" => "60",
                "scheduled" => false,
                "auto_recording" => false,
                "active_talker" => true,
                "wait_moderator" => false,
                "adhoc" => false,
            ),
            "sip" => array(
                "enabled" => false,
            ),
        );

        $Room_Meta = json_encode($Room);
        $response = $this->curlOperations(['type' => 'POST', 'url' => '/rooms', 'data' => $Room_Meta]);

        return response($response);

    }

    public function getRoom(Request $request)
    {
        $roomId = $request->route('room');
        if (!$roomId) {
            $error = Errors::getError(4001);
            $error["desc"] = "Failed to get roomId from URL";
            return response()->json($error);
        }

        $response = $this->curlOperations(['type' => 'GET', 'url' => "/rooms/" . $roomId]);
        return response($response);
    }

    public function createToken(Request $request)
    {
        if (!$request->name && !$request->role && !$request->roomId) {
            $error = Errors::getError(4004); // Required JSON Key missing
            $error["desc"] = "JSON keys missing: name, role or roomId";
            return response()->json($error);
        }
        $Token = array(
            "name" => $request->name,
            "role" => $request->role,
            "user_ref" => $request->user_ref,
        );

        $Token_Payload = json_encode($Token);

        $response = $this->curlOperations(['type' => 'POST', 'url' => "/rooms/" . $request->roomId . "/tokens", 'data' => $Token_Payload]);
        return response($response);

    }

    public function confo(Request $request, $room, $type, $ref)
    {
        return \view('confo')->with(['roomId' => $room, 'user_ref' => $ref, 'usertype' => $type]);
    }
}
