@extends('user.layouts.user_master')
@push('styles')
<style>
    .active_group{
        background-color: #d4edda;
        border-right: 4px solid #28a745;
    }
</style>
@endpush
@section('user-content')
    <div class="container-fluid mt-3" id="__groupchat_app" v-cloak>
        <div class="row" >
            <div class="col-lg-3">
                <div class="card " >
                    <div class="card-body">
                        <h5 class="text-center">My Groups</h5>
                        <ul class="list-group mt-2 overflow-auto" style="max-height: 75vh;">
                            @foreach ($my_groups as $group)
                            <li>
                                <a class="list-group-item text-decoration-none text-dark d-flex justify-content-between align-items-center @if($group->id == $group_details->id) active_group @endif" href="{{ route('group_chat',$group->id) }}">{{$group->group_name}}
                                @if (auth()->user()->id == $group->group_admin)
                                    <span class="badge badge-success" >Admin</span>
                                @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card overflow-hidden bg-light" style="height: 85vh;">
                    <div class="card-body p-2">
                        <div>
                            <div class="card">
                                <div class="card-body p-2">
                                    <div style="height: 70vh;" class="d-flex flex-column group_message_area overflow-auto">
                                        <div :class="index==messages.length -1 ? `user_last_msg` : `user_msg` " v-for="(message,index) in messages" :key="index">
                                            <div class="alert d-inline-flex flex-column justify-content-between px-2 py-0 rounded mb-1" style="max-width: 80%;" :class="message.user_id==$refs.auth_user.value ? 'float-right alert-success border-success' :'float-left alert-dark border-dark' " >
                                                <div class="d-flex justify-content-between">
                                                    <div class="font-weight-bold mr-3" style="font-size:14px">@{{message.name}}</div> 
                                                    <strong class="text-right" style="font-size:14px">@{{message.message_create_time}}</strong>
                                                </div>
                                                <div>@{{message.message}}</div>
                                            </div>
                                        </div>
                                        <div v-if="messages.length==0 && loading_message==false" class="text-center mt-3"><h5>No messages found.</h5></div>
                                        <div v-if="messages.length==0 && loading_message==true" class="text-center mt-3"><h5>Loading...</h5></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <input type="text" class="form-control" cols="10" rows="1" style="resize: none;" placeholder="Type message here.." v-model="my_message" @keyup.enter="send_message" />
                            <button type="button" class="btn btn-success ml-2 font-weight-bold px-4" @click="send_message" :disabled="is_sent">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-info p-3">
                            <h5 class="text-center"><u>Group Details</u></h5>
                            <input type="hidden" value="{{$group_details->id}}" ref="group_id">
                            <input type="hidden" value="{{auth()->user()->id}}" ref="auth_user">
                            <hr>
                            <h6>Total Members: {{count($group_details->members)}}</h6>
                            <ul class="list-group mt-2 overflow-auto" style="max-height: 62vh;">
                                @foreach ($group_details->members as $member)
                                <li class="list-group-item p-1 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>{{$member->name}}</strong>
                                        @if ($member->id == $group_details->group_admin)
                                            <span class="badge badge-success" >Admin</span>
                                        @else
                                            <button class="btn btn-danger btn-sm py-0">X</button>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/modules/group_chat.js') }}"></script>
@endpush