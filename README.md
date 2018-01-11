# laravel-pcmn
laravel-pcmn is a simple yet powerful CMS you can use to manage your sites' content.
The CMS is a 'programmers' CMS, which means you have to build your site yourself using your favorite framework: Laravel.
The content however can easily be managed with this CMS. 

All you need to do is focus on your application, the hassle of managing the content is done by PCMN!

PCMN is designed to be as invisible as possible, meaning it won't interfere with the way you build your site or application.



### Installation

Composer require 
"kluverp/laravel-pcmn": "dev-master"
Add the following to youer composer.json:
"repositories": [
        {
            "type": "vcs",
            "url": "git://github.com/kluverp/laravel-pcmn.git"
        }
    ]

Add the Service Provider to "config/app.php":       
'pcmn' => \Kluverp\Pcmn\Providers\PcmnServiceProvider::class

Add the Pcmn Middleware the the /app/Http/Kernel.php file in the $routeMiddleware array:
'pcmn' => \Kluverp\Pcmn\Middleware\Pcmn::class

Publish the assets:
php artisan vendor:publish --tag=public --force