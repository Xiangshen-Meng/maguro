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

}
