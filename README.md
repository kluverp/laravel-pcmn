# laravel-pcmn
laravel-pcmn


php artisan vendor:publish --tag=public --force


config/auth.php

'pcmn' => [
            'driver' => 'session',
            'provider' => 'pcmn_users',
        ],
        
        
'pcmn_users' => [
             'driver' => 'eloquent',
             'model' => Kluverp\Pcmn\Models\User::class,
         ],
