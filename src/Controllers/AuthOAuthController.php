<?php

namespace Exceedone\Exment\Controllers;

use Exceedone\Exment\Services\Login\LoginService;
use Exceedone\Exment\Services\Login\OAuth\OAuthUser;
use Exceedone\Exment\Model\LoginSetting;
use Exceedone\Exment\Model\Define;
use Exceedone\Exment\Auth\ThrottlesLogins;
use Exceedone\Exment\Enums\LoginType;
use Illuminate\Http\Request;

/**
 * For login oauth controller
 */
class AuthOAuthController extends \Encore\Admin\Controllers\AuthController
{
    use AuthTrait;

    public function __construct()
    {
        $this->maxAttempts = config("exment.max_attempts", 5);
        $this->decayMinutes = config("exment.decay_minutes", 60);

        $this->throttle = config("exment.throttle", true);
    }

    /**
     * Login page using provider (SSO).
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getLoginProvider(Request $request, $login_provider)
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        // provider check
        $socialiteProvider = LoginSetting::getSocialiteProvider($login_provider);
        if (!isset($socialiteProvider)) {
            abort(404);
        }
        return $socialiteProvider->redirect();
    }

    /**
     * callback login provider and login exment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function callback(Request $request, $provider_name)
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }
        
        $error_url = admin_url('auth/login');
        try{
            $credentials = ['login_type' => LoginType::OAUTH, 'login_setting' => LoginSetting::getOAuthSetting($provider_name)];
            if ($this->guard()->attempt($credentials)) {
                session([Define::SYSTEM_KEY_SESSION_AUTH_2FACTOR => true]);

                // set session access key
                LoginService::setToken($custom_login_user);
                
                return $this->sendLoginResponse($request);
            }
    
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);
    
            return back()->withInput()->withErrors([
                'sso_error' => $this->getFailedLoginMessage(),
            ]);

        } 
        // Sso exception
        catch (SsoLoginErrorException $ex) {
            \Log::error($ex);
            return redirect($error_url)->withInput()->withErrors(
                ['sso_error' => $ex->getSsoErrorMessage()]
            );
        } catch (\Exception $ex) {
            \Log::error($ex);
            return redirect($error_url)->withInput()->withErrors(
                ['sso_error' => exmtrans('login.sso_provider_error')]
            );
        }
    }
}
