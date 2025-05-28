<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{!! csrf_token() !!}" />
        <title>ipChat</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
        <style>
            [v-cloak] {
                display: none;
            }
        </style>
    </head>
    <body class="bg-dark">
        <div id="__login_app" v-cloak>
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="card col-xl-3 col-lg-5 col-md-6 col-10">
                    <div class="card-body">
                        <form action="#" @submit.prevent="login_user">
                            <h3 class="text-center">User Login</h3>
                            <hr>
                            <div class="alert alert-danger" v-if="!!login_error">
                                @{{login_error}}
                            </div>
                            <div class="alert alert-success" v-if="success_login">
                                Loggedin successfully
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="email" id="user_email" class="form-control" v-model="form.email">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" id="user_password" class="form-control" v-model="form.password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark px-4 btn-block" :disabled=" form.email=='' || form.password=='' ">Login</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-link text-center w-100" @click="forgot_password_instructions=!forgot_password_instructions">Forgot Password?</button>
                            </div>
                            <div class="alert alert-warning border-warning p-2 mt-3" v-if="forgot_password_instructions">
                                <ul class="m-0">
                                    <li>We don't have forgot password facility.😕</li>
                                    <li>It's your responsibility to remember your password.😒</li>
                                    <li>Abhi kuch nahi ho sakta. Maulik ko contact karo 😏</li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules/login.js') }}"></script>

</html>
