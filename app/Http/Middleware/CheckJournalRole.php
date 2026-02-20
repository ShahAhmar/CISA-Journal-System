<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJournalRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $journal = $request->route('journal');
        
        if (!$journal) {
            abort(404);
        }

        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admin has access to all journals
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Check if user has required role for this journal
        $hasRole = false;
        foreach ($roles as $role) {
            if ($user->hasJournalRole($journal->id, $role)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}

