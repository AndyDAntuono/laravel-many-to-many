<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
{
    Log::info('AdminMiddleware: verificando autenticazione...');

    // Verifica se l'utente è autenticato
    if (!Auth::check()) {
        Log::warning('AdminMiddleware: utente non autenticato!');
        return redirect()->route('login')->with('error', 'Devi effettuare il login per accedere.');
    }

    // Logga l'ID dell'utente autenticato e se è admin
    Log::info('AdminMiddleware: utente autenticato con ID ' . Auth::id());
    Log::info('AdminMiddleware: utente è admin? ' . (Auth::user()->is_admin ? 'Sì' : 'No'));

    // Controlla se l'utente è un amministratore
    if (!Auth::user()->is_admin) {
        Log::info('AdminMiddleware: utente non amministratore, reindirizzo a /');
        return redirect()->route('dashboard')->with('error', 'Accesso negato.');
    }

    Log::info('AdminMiddleware: utente amministratore, consentito l\'accesso.');
    return $next($request);
}

}
