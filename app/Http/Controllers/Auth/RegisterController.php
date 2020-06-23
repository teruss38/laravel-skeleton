<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneRegisterRequest;
use App\Notifications\WelcomeNotification;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 前台用户注册
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        if ($request->user()) {
            return redirect(url()->previous());
        } else if (!settings('user.enable_registration')) {
            return redirect(url()->previous())->with('status', trans('user.registration_closed'));
        }
        return view('auth.register');
    }

    /**
     * 显示手机号码注册窗口
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showPhoneRegistrationForm(Request $request)
    {
        if ($request->user()) {
            return redirect(url()->previous());
        } else if (!settings('user.enable_registration')) {
            return redirect(url()->previous())->with('status', trans('user.registration_closed'));
        }
        return view('auth.register-phone');
    }

    /**
     * 手机注册
     * @param PhoneRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function phoneRegister(PhoneRegisterRequest $request)
    {
        event(new Registered($user = UserService::createByPhone($request->phone, $request->password)));
        $this->guard()->login($user);
        $user->markPhoneAsVerified();//标记为已验证
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'username' => ['required', 'string', 'max:255', 'nickname', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['accepted'],
        ];
        if (config('app.env') != 'testing') {
            $rules['ticket'] = ['required', 'ticket:register'];//开启防水墙
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return UserService::createByUsernameAndEmail($data['username'], $data['email'], $data['password']);
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //发送欢迎邮件
        if (settings('user.enable_welcome_email') && !empty($user->email)) {
            $user->notify(new WelcomeNotification($user->username));
        }
        return;
    }
}
