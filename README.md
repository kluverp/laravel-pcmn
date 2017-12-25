# laravel-pcmn
laravel-pcmn



config/auth.php

'pcmn' => [
            'driver' => 'session',
            'provider' => 'pcmn_users',
        ],
        
        
'pcmn_users' => [
             'driver' => 'eloquent',
             'model' => Kluverp\Pcmn\Models\User::class,
         ],
