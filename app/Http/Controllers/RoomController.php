<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Helpers\ChatManager\ChatManager;
use App\Http\Requests\RoomAuthorizePost;
use App\Room;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RoomController extends Controller
{

    public function createRoom(Request $request)
    {
        $tagNames = Tag::all()->map(function ($tag) {
            return $tag->name;
        }); 
        $this->validate($request, [
            'roomname' => 'required|string|min:3',
            'private' => 'required|boolean',
            'tag' => 'required|in:'.$tagNames,
            'password' => 'required_if:private,true|string|min:4',
            'repassword' => 'required_if:private,true|same:password'
        ]);

        $room = new Room;
        $room->name = $request->roomname;
        $room->path = $request->roomname.'_'.uniqid().'.json';
        $room->isPrivate = $request->private;
        $room->password = ($request->private) ? Hash::make($request->password) : null;
        
        if(!file_exists(database_path('JsonDatabase/'.$room->path))){
            if(!ChatManager::createRoomFile($room)){
                return ['status' => 'failed'];
            }
        }
        
        $tag = Tag::where('name', $request->tag)->firstOrFail();
        $room->save();
        $room->tags()->attach($tag);
        $room->users()->attach(Auth::user());

        return ['status' => 'success'];
    }

    public function authorizeUser(RoomAuthorizePost $request)
    {
        $user = Auth::user();
        $room = Room::where('name', $request->roomname)->firstOrFail();
        if(!$room->users->contains($user->id)){
            $room->users()->attach($user);
        }
        
        return [
            'status' => 'success',
            'url' => route('room', ['id' => $room->name]),
        ];
    }

    public function sendMessage(Request $request, $id)
    {
        $room = Room::where('name', $id)->firstOrFail();
        $message = $request->input('message');
        ChatManager::addMessage($room, $message);
        broadcast(new MessageSent($id, $message));
        
        return ['status' => 'success'];
    }

    public function fetchMessages($id)
    {
        $messages = ChatManager::getChatArrayMessagesWithUserName($id);

        return [
            'status' => 'success',
            'messages' => $messages
        ];
    }

    public function addFavorite($id)
    {
        $user = Auth::user();
        $room = Room::where('name', $id)->firstOrFail();
        if(!$room->fav_users->contains($user->id)){
            $user->fav_rooms()->attach($room);
            return ['status' => 'success'];
        }else{
            $user->fav_rooms()->detach($room);
            return ['status' => 'success'];
        }
       
    }

    public function fetchFavorites()
    {
        $user = Auth::user();
        $favs = $user->fav_rooms()->get()->map(function ($room) {
            return $room->name;
        });
        return [
            'status' => 'success',
            'favorites' => $favs
        ];
    }
}