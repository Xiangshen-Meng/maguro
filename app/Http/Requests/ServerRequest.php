<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class ServerRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        $server = $this->route('server');
        return $server ? $server->user_id == Auth::id() : Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'admin_user' => 'required|max:255',
		];
	}

}
