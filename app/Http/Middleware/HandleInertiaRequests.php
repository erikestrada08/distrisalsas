<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            // Compat: mantener 'user' directo (ya usado en varias vistas)
            'user' => $request->user(),
            // Breeze/Profile espera props en auth.user
            'auth' => [
                'user' => $request->user(),
            ],
            'modulos' => session('modulos', []),
        ];
    }
}
