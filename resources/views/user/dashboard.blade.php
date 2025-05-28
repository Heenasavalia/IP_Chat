@extends('user.layouts.user_master')
@section('user-content')
    <div class="container mt-5" id="__dashboard_app" v-cloak>
        <div class="alert alert-info border-info">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="font-weight-light m-0">Welcome User</h3>
                <button class="btn btn-info btn-sm px-3 font-weight-bold" @click="create_group_modal=true">Create Group</button>
            </div>
        </div>
        <div v-if="create_group_modal">
            <div class="position-fixed" style="height:100vh;width:100%;z-index:999;top: 0px;left: 0px;">
                <div class="d-flex justify-content-center align-items-center mt-5">
                    <div class="col-xl-4 col-lg-6 col-sm-10">
                        <div class="card">
                            <div class="card-body">
                                <form action="#" @submit.prevent="create_group">
                                    <h3 class="text-center">Create Group</h3>
                                    <hr>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Group Name</label>
                                        <input type="text" class="form-control d-block" v-model="group_form.name" maxlength="25">
                                        <em class="text-muted">You will be Admin of this group</em>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Group Members</label>
                                        <div class="d-flex">
                                            <input type="text" class="form-control d-block" v-model="search_user">
                                            <button type="button" class="btn btn-info px-3 font-weight-bold ml-2" @click="searchUser" :disabled="disable_user_search">Search</button>
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                            <strong class="bg-success p-1 px-2 text-white rounded mr-2 h6" v-for="(member,index) in group_form.members">@{{member.name}}</strong>
                                        </div>
                                        <div class="mt-3 alert alert-success border-success p-2 overflow-auto" style="max-height:200px" v-if="searched_users.length > 0">
                                            <div v-for="(user,index) in searched_users" class="alert border-success alert-light py-0 px-2 mb-1" :key="index">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <div class="text-dark font-weight-bold">@{{user.name}}</div>
                                                        <div class="text-muted">@{{user.email}}</div>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-success" @click="add_user_to_group(user)" v-if="!group_form.members.find(item => item.id == user.id)">Add</button>
                                                        <button type="button" class="btn btn-sm btn-danger" @click="remove_user_to_group(user.id)" v-if="group_form.members.find(item => item.id == user.id)">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success font-weight-bold px-3" :disabled="isDisableCreateGroupSubmit" ref="groupSubmitBtn">Create</button>
                                        <button type="button" class="btn btn-danger font-weight-bold px-3" @click="create_group_modal=false">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-fixed" style="background:linear-gradient(to right,rgba(0,0,0,0.5),rgba(0,0,0,0.5));height:100vh;width:100%;top: 0px;left: 0px;z-index:99" @click="create_group_modal=false"></div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Group Name</th>
                        <th>Group Members</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(group,index) in users_group" :key="index">
                        <th>@{{index+1}}</th>
                        <th><a :href="`{{ url('user/chat') }}/${group.id}`">@{{group.group_name}}</a></th>
                        <th>@{{group.member_names}}</th>
                        <td>@{{group.group_create_date}}</td>
                        <td>
                            <a :href="`{{ url('user/chat') }}/${group.id}`" type="button"  class="btn btn-success font-weight-bold btn-sm px-4">Chat</a>
                            <button type="button" @click="delete_group" class="btn btn-danger font-weight-bold  btn-sm ">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="users_group.length == 0">
                        <th colspan="5" class="text-center h4">Loading..</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/modules/dashboard.js') }}"></script>
@endpush