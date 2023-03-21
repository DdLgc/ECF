<?php

namespace App\Security;

use App\Controller\SecurityController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private $userRepository;
    private $urlGenerator;

    public function __construct(UserRepository $userRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->userRepository = $userRepository;
        $this->urlGenerator = $urlGenerator;
        // dd($userRepository);
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    /**
     * Create a passport for the current request.
     *
     * The passport contains the user, credentials and any additional information
     * that has to be checked by the Symfony Security system. For example, a login
     * form authenticator will probably return a passport containing the user, the
     * presented password and the CSRF token value.
     *
     * You may throw any AuthenticationException in this method in case of error (e.g.
     * a UserNotFoundException when the user cannot be found).
     *
     * @return Passport
     *
     * @throws AuthenticationException
     */
    public function authenticate(Request $request)// UserPasswordEncoderInterface $encoder   CODE
    {
        $api_token = $request->request->get('csrf_token');
        if ($api_token === null) {
            throw new CustomUserMessageAuthenticationException("no access");
        }

        $email = $request->request->get("email");
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password')), [
                new CsrfTokenBadge ('login_form', $request->request->get('csrf_token'))
            ]
        );
        //    print_r($user->getId());
        //// dd($user);
        //if (!$user) {
        //    throw new CustomUserMessageAuthenticationException('Invalid credentials');
        //
        //}
        // if ($encoder)
        // print_r($request->request->get('email'));  CODE MIS EN COMMENTAIRE APRES LE COURS
    }

    /**
     * Create an authenticated token for the given user.
     *
     * If you don't care about which token class is used or don't really
     * understand what a "token" is, you can skip this method by extending
     * the AbstractAuthenticator class from your authenticator.
     *
     * @param PassportInterface $passport The passport returned from authenticate()
     *
     * @see AbstractAuthenticator
     *
     * @deprecated since Symfony 5.4, use {@link createToken()} instead
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response("Loggin failed", 400);
        //$this->return(
        // 'error'
        //'Logged fail !!'// $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        //);
        //return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
