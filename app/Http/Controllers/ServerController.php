<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ServerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $servers = Auth::user()->servers;
        return view('server.index', compact('servers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('server.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ServerRequest $request)
	{
        Auth::user()->servers()->create($request->all());
        return redirect('home');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($server)
	{
        $sites = $server->sites;
		return view('server.show', compact('server', 'sites'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($server)
	{
        if ($server->user_id == Auth::id()) {
            return view('server.edit', compact('server'));
        } else {
            return redirect('home')->with('message', "You can't edit this server.");
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ServerRequest $request, $server)
	{
        $server->update($request->all());
        return redirect()->route('server.show', $server);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($server)
	{
        $server->sites()->delete();
        $server->delete();
        return redirect('home');
	}

    public function bash($server)
    {
        $cmd_stop_service = "service ghost stop; service nginx stop;";
        $cmd_clean_up_ghost = "rm /etc/nginx/sites-enabled/ghost;rm /etc/nginx/sites-available/ghost;rm /etc/init.d/ghost;rm /etc/init/ghost.conf;rm -rf /var/www/ghost;";

        $build_cmd = $cmd_stop_service . $cmd_clean_up_ghost;

        foreach($server->sites as $site) {
            $nginx_service_content = view('templates.nginx_config', compact('site'))->render();
            $init_service_content = view('templates.init_service', compact('site'))->render();
            $ghost_config_content = view('templates.ghost_config_0_6_4', compact('site'))->render();

            $site_name = str_replace('.', '-', $site->domain);
            $cmd_nginx_config = "echo '" . $nginx_service_content . "' > /etc/nginx/sites-available/" . $site_name . '.conf;cd /etc/nginx/sites-enabled;ln -s ../sites-available/'. $site_name . '.conf ./;';
            $cmd_initd_config = "echo '" . $init_service_content . "' > /etc/init/ghost-" . $site_name . ".conf;cd /etc/init.d; ln -s /etc/init/ghost-" . $site_name . ".conf ./ghost-" . $site_name . ";";

            $build_cmd .= $cmd_nginx_config;
            $build_cmd .= $cmd_initd_config;

            $cmd_download_ghost = "cd /tmp;wget https://ghost.org/zip/ghost-0.6.4.zip -O ghost.zip;apt-get install -y unzip;rm -rf ghost;unzip ghost.zip -d ghost;";
            $cmd_ghost_config = 'echo "' . $ghost_config_content . '" > /tmp/ghost/config.js;mv /tmp/ghost /var/www/' . $site->domain . ' && cd /var/www/'. $site->domain .' && npm install --production; chown -R ghost:ghost /var/www/' . $site->domain . ';';
            $build_cmd .= $cmd_download_ghost;
            $build_cmd .= $cmd_ghost_config;

            $cmd_ghost_start = 'service ghost-' . $site_name . ' start;';
            $build_cmd .= $cmd_ghost_start;
        }
        $cmd_restart_service = 'service nginx restart;';
        $build_cmd .= $cmd_restart_service;
        dd($build_cmd);
    }

}
