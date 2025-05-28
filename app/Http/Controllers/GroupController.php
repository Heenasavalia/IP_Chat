<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function group_chat($group_id){
        $group_details=Group::findOrFail($group_id);
        if($group_details){
            $member_id=$group_details->members ? json_decode($group_details->members,true) : [];
            $members=User::whereIn('id',$member_id)->get();
            $group_details->members=$members;
        }
        $my_groups=Group::whereJsonContains('members',auth()->user()->id)->select('id','group_name','group_admin','created_at')->get();

        return view('user.chat_group.chat_group',compact('group_details','my_groups'));
    }

    public function userwise_group_list(Request $request){
        $my_groups=Group::whereJsonContains('members',auth()->user()->id)->select('id','group_name','members','created_at')->get();
        foreach($my_groups as $group){
            $members=User::whereIn('id',json_decode($group->members,true))->pluck('name')->toArray();
            $group->member_names=implode(',',$members);
        }
        return response()->json(['status'=>true,'data'=>$my_groups]);
    }

    public function get_group_messages(Request $request){
        $group_id=$request->group_id;
        $messages=GroupMessage::join('users','users.id','group_messages.user_id')
        ->where('group_messages.group_id',$group_id)
        ->select('group_messages.*','users.name')
        ->get();
        return response()->json(['status'=>true,'data'=>$messages]);
    }
    public function send_group_message(Request $request){
        $group_id=$request->group_id;
        $message=$request->message;
        GroupMessage::create([
            'group_id' => $group_id,
            'user_id' => auth()->user()->id,
            'message' => $message
        ]);
        return response()->json(['status'=>true]);
    }


    public function create_group(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'members'=>'required|array',
        ]);
        if($validator->fails()){
            $error=$validator->errors()->first();
            return response()->json(['status'=>false,'message'=>$error]);
        }
        else{
            $members=$request->members;
            if(count($members)>5){
                return response()->json(['status'=>false,'message'=>"Cannot add members more than 5!"]);
            }
            array_unshift($members,auth()->user()->id);
            $create=Group::create([
                'group_name'=>$request->name,
                'members'=>json_encode($members,true),
                'group_admin'=>auth()->user()->id,
                'type'=>1,
            ]);
            if($create){
                return response()->json(['status'=>true,'message'=>'Group create successfully']);
            }
            else{
                return response()->json(['status'=>false,'message'=>"Group could not created"]);
            }
        }
    }

}
