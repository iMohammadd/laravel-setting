#Laravel Setting

install via composer

`composer require aries/laravelsetting`

Add Service Provider to `config/app.php` providers array:
```php
'providers' => [
    ....
    Aries\LaravelSetting\LaravelSettingServiceProvider::class,
]
```

And add alias to aliases array:
```php
'aliases' => [
    ...
    'Setting' => Aries\LaravelSetting\Facade\Setting::class,
]
```

And publish vendor

```php
php artisan vendor:publish```

And migrate database

```php
php artisan migrate```

**Usage**
```php
<?php
namespace App\Http\Controllers;

use Aries\LaravelSetting\Facade\Setting;

class SettingController extends Controller {
    public function index(){
        #Set a Setting property:
        Setting::set('key', 'value');
        
        #Get a Stored Setting value or pass default value
        $setting['key'] = Setting::get('key', 'default value');
    }
    
    public function store(\Request $request){
        #get all settings from an key-value array and store them to database
        #example: <input type="text" name="setting['title']">
        Setting::store($request->input('setting'));
    }
}
```
