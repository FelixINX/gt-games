<?php

namespace App\Http\Middleware;

use App\Model\Invitation;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HasInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Only for GET requests. Otherwise, this middleware will block our registration.
         */
        if ($request->isMethod('get')) {

            /**
             * No token = Goodbye.
             */
            if (!$request->has('token')) {
                return redirect(route('request.show'));
            }

            $invitation_token = $request->get('token');

            /**
             * Lets try to find invitation by its token.
             * If failed -> return to request page with error.
             */
            try {
                $invitation = Invitation::where('invitation_token', $invitation_token)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return redirect(route('request.show'))
                    ->with('error', 'Le token est invalide! Veuillez vérifier l\'URL.');
            }

            /**
             * Let's check if users already registered.
             * If yes -> redirect to login with error.
             */
            if (!is_null($invitation->registered_at)) {
                return redirect(route('login'))->with('error', 'Le token a déja été utilisé, veuillez-vous connecter.');
            }
        }

        return $next($request);
    }
}
