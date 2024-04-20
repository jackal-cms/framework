<?php

namespace Quagga\Quagga\Foundation\Auth;

use Quagga\Quagga\Exceptions\Validation\ValidationException;
use Slim\Psr7\Request;
use Valitron\Validator;

trait AuthenticatesUsers
{
    use RedirectsUsers;
    use ThrottlesLogins;

    protected function validateLogin(Request $request)
    {
        $params = $request->getQueryParams();
        $v = new Validator($params);
        $v->rule('required', [$this->username(), 'password']);

        if ($v->validate()) {
            return true;
        }
        throw new ValidationException();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
