<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

/**
 * 社交账户登录
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SocialLoginController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        $redirectTo = Session::previousUrl();
        if (!$redirectTo) {
            $redirectTo = $this->redirectTo;
        }
        return $redirectTo;
    }

    /**
     * 社交账户登录
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(Request $request, $provider)
    {
        try {
            Session::setPreviousUrl(URL::previous());
            $driver = Socialite::driver($provider);
            if ($provider == 'qq') {
                $driver->withUnionId();
            }
            return $driver->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect($this->redirectTo())->with('status', trans('user.not_supported_yet'));
        }
    }

    /**
     * 社交账户回调
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        /** @var \Laravel\Socialite\Contracts\User $socialUser */
        $socialUser = Socialite::driver($provider)->user();
        $social = UserService::getSocialUser($provider, $socialUser);
        if ($social->user == null) {//用户未绑定
            if ($request->user()) {//已经登录，自动绑定
                $social->connect($request->user());
                return redirect($this->redirectTo());
            } else {
                $request->session()->put('social_id', $social->id);
                return redirect("/auth/social/{$provider}/binding", 302)->with('status', trans('user.login_bind'));
            }
        } else {//如果已经绑定过了账户，这里检查用户是否被禁用
            if ($social->user->hasDisabled()) {
                return redirect('/login')->with('status', trans('user.account_has_been_blocked'));
            } else {
                Auth::login($social->user);
                $social->user->updateLogin( $request->getClientIp(), $request->userAgent());
                return redirect($this->redirectTo());
            }
        }
    }

    /**
     * 绑定社交账户
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handleProviderBinding(Request $request, $provider)
    {
        return view('auth.binding');
    }
}
