<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\SiteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller {

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($server)
	{
        return view('site.create', compact('server'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SiteRequest $request, $server)
	{
        Auth::user()->sites()->create($request->all());
        return redirect()->route('server.show', $server);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($server, $site)
	{
        return view('site.show', compact('server', 'site'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($server, $site)
	{
        if ($site->user_id == Auth::id()) {
            return view('site.edit', compact('server', 'site'));
        } else {
            return redirect('home')->with('message', "You can't edit this site.");
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SiteRequest $request, $server, $site)
	{
        $site->update($request->all());
        return redirect()->route('server.site.show', [$server, $site]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($server, $site)
	{
        $site->delete();
        return redirect()->route('server.show', $server);
	}

}
