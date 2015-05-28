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

    public function cleanupDefaultBash()
    {
        $build_cmd = '';

        $cmd_stop_service = "service ghost stop;";
        $cmd_clean_up_ghost = "rm /etc/nginx/sites-enabled/ghost;"
                            . "rm /etc/nginx/sites-available/ghost;"
                            . "rm /etc/init.d/ghost;"
                            . "rm /etc/init/ghost.conf;"
                            . "rm -rf /var/www/ghost;";

        $build_cmd .= $cmd_stop_service;
        $build_cmd .= $cmd_clean_up_ghost;

        return $build_cmd;
    }

    public function createBash()
    {
        $site_name = str_replace('.', '-', $this->domain);
        $build_cmd = '';

        $nginx_service_content = view('templates.nginx_config', ['site' => $this])->render();
        $init_service_content = view('templates.init_service', ['site' => $this])->render();
        $ghost_config_content = view('templates.ghost_config_0_6_4', ['site' => $this])->render();

        $cmd_nginx_config = "echo -e '" . $nginx_service_content . "' > /etc/nginx/sites-available/" . $site_name . '.conf;'
                            . 'cd /etc/nginx/sites-enabled;'
                            . 'ln -s ../sites-available/'. $site_name . '.conf ./;';
        $cmd_initd_config = "echo -e '" . $init_service_content . "' > /etc/init/ghost-" . $site_name . ".conf;"
                            . "cd /etc/init.d;"
                            . "ln -s /etc/init/ghost-" . $site_name . ".conf ./ghost-" . $site_name . ";";

        $build_cmd .= $cmd_nginx_config;
        $build_cmd .= $cmd_initd_config;

        $cmd_download_ghost = "cd /tmp;wget https://ghost.org/zip/ghost-0.6.4.zip -O ghost.zip;"
                            . "apt-get install -y unzip;rm -rf ghost;"
                            . "unzip ghost.zip -d ghost;";
        $cmd_ghost_config = 'echo -e "' . $ghost_config_content . '" > /tmp/ghost/config.js;'
                            . 'mv /tmp/ghost /var/www/' . $this->domain . ' && cd /var/www/'. $this->domain .' && npm install --production;'
                            . 'chown -R ghost:ghost /var/www/' . $this->domain . ';';

        $build_cmd .= $cmd_download_ghost;
        $build_cmd .= $cmd_ghost_config;

        $cmd_ghost_start = 'service ghost-' . $site_name . ' start;'
                        . 'service nginx restart';
        $build_cmd .= $cmd_ghost_start;

        return $build_cmd;
    }

    public function removeBash()
    {
        $build_cmd = '';
        $site_name = str_replace('.', '-', $this->domain);

        $cmd_ghost_stop = 'service ghost-' . $site_name . ' stop;';
        $cmd_clean_up_ghost = "rm /etc/nginx/sites-enabled/" . $site_name . ".conf;"
            . "rm /etc/nginx/sites-available/" . $site_name . ".conf;"
            . "rm /etc/init.d/ghost-" . $site_name . ";"
            . "rm /etc/init/ghost-" . $site_name . ".conf;"
            . "rm -rf /var/www/" . $this->domain . ";";
        $cmd_restart_nginx = 'service nginx restart;';

        $build_cmd .= $cmd_ghost_stop;
        $build_cmd .= $cmd_clean_up_ghost;
        $build_cmd .= $cmd_restart_nginx;

        return $build_cmd;
    }
}
