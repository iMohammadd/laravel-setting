<?php
namespace Aries\LaravelSetting\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    protected $fillable = ['key', 'value', 'is_primary', 'autoload'];
}
