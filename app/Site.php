<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model {

    protected $fillable = ['server_id', 'name', 'domain', 'port'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function server()
    {
        return $this->belongsTo('App\Server', 'server_id');
    }
}
