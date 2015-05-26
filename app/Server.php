<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model {

    protected $fillable = ['name', 'address', 'admin_user'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function sites()
    {
        return $this->hasMany('App\Site');
    }
}
