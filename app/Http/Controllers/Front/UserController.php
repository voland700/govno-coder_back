<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function userAuth()
    {
        return view('front.layouts.login');
    }

    public function userAuthStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            ],  $messages = [
                'email.required' => 'Поле Email обязательно для заполенния',
                'email.email' => 'Укажите корректный Email адрес',
                'password.required' => 'Укажите Пароль'
            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return response(view('front.layouts.login')->withErrors($validator)->render(), 422);
        } else {

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                return  response('', 200);
            } else {
                $request->flash();
                $errors[0] = "Hе корректный Email или Пароль";
                return response(view('front.layouts.login')->withErrors($errors)->render(), 422);
            }
        }
    }

    public  function userRegister()
    {
        return view('front.layouts.register');
    }

    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],  $messages = [
                'name.required' => 'Поле имя обязательно для заполенния',
                'name.max:255' => 'Поле имя не должно превышать 255 символов',
                'email.required' => 'Поле Email обязательно для заполенния',
                'email.email' => 'Укажите корректный Email адрес',
                'email.unique' => 'Пользователь с указанным Email адресом уже зарегистрирован',
                'password.required' => 'Укажите Пароль',
                'password.confirmed' => 'Не провильно указаны данные при подтверждении пароля',
                'password.min' => 'Пароль должен содержать не менее :min символов'
            ]
        );

        if ($validator->fails()) {
            $request->flash();
            return response(view('front.layouts.register')->withErrors($validator)->render(), 400);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            event(new Registered($user));
            Auth::login($user);
            return response('<h3>Ура! Вы зарегистрированы!</h3>', 200);
        }
    }





}
