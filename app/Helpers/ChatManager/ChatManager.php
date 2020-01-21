<?php

namespace App\Helpers\ChatManager;

use App\Room;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ChatManager {
    
    private $chatCollection;

    public function __construct(){
        foreach (Room::all() as $room) {
            $path = database_path('JsonDatabase/'.$room->path);
            $json = json_decode(file_get_contents($path), true);
            $this->chatCollection[$room->name] = collect($json['messages']);
        }
    }

    public static function createRoomFile(Room $room, string $owner = null){
        $path = database_path('JsonDatabase/'.$room->path);
        $json = json_encode((object) [
            "roomname" => $room->name,
            "owner" => ($owner == null) ?  Auth::user()->id : $owner,
            "messages" => []
        ]);
        if($json == false) return $json;

        file_put_contents($path, $json);
        return true;
    }

    public function getCollection()
    {
        return $this->chatCollection;
    }

    public static function getChatCollectionMessages($roomname){
        try{
            return app(ChatManager::class)->getCollection()[$roomname];
        }catch(Exception $e){
            throw new ModelNotFoundException();
        }
    }

    public static function getChatArrayMessagesWithUserID($roomname){
        try{
            return app(ChatManager::class)->getCollection()[$roomname]->toArray();
        }catch(Exception $e){
            throw new ModelNotFoundException();
        }
    }

    public static function getChatArrayMessagesWithUserName($roomname)
    {
        $messages = ChatManager::getChatArrayMessagesWithUserID($roomname);
        $tempIdToNameArray = [];

        foreach ($messages as $key => $value) {
            $idToName = (isset($tempIdToNameArray[$value['user']])) ? $tempIdToNameArray[$value['user']] : (User::find($value['user']))->name;
            $tempIdToNameArray[$value['user']] = $idToName;
            $messages[$key]['user'] = $idToName;
        }
        return $messages;
    }

    public static function addMessage(Room $room, string $message){
        $path = database_path('JsonDatabase/'.$room->path);
        $json = json_decode(file_get_contents($path), true);
        array_push($json['messages'], array('user' => (Auth::user())->id, 'message' => $message));
        file_put_contents($path, json_encode($json));
    }
}