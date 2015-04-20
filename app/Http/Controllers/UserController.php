<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends Controller {


	public function __construct()
	{
		$this->middleware('auth.api');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index( )
	{
		$users = User::findAll();
		return $this->response( 200, $users );
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

	    $v = \Validator::make( $request->all(), [
	        'email' 	=> 'required|unique:users|email',
	        'password'	=> 'required|min:8',
	    ]);

	    if ( $v->fails() ) 
	    {
	    	return $this->response( 422, null, $v->errors() );
	    }

		$user = new User;
		$user->first_name 	= $request->input('first_name');
		$user->first_name 	= $request->input('first_name');
		$user->name 		= $user->first_name . ' ' . $user->last_name;
		$user->email 		= $request->input('email');
		$user->password 	= bcrypt( $request->input('first_name') );

		return $this->response(201, $user->transform() );
	}

	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show( $id )
	{
		$user = User::find( $id );

		if( ! $user )
		{
			return $this->response(400 );
		}		

		return $this->response( 200, $user->transform() );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update( Request $request, $id )
	{
		$user = User::find( $id );

		if( ! $user )
		{
			return $this->response( 400 );
		}	
		
		$user->first_name 	= $request->get('first_name');
		$user->last_name 	= $request->get('last_name');
		$user->name 		= $user->first_name . ' ' . $user->last_name;
		$user->save();

		return $this->response( 200, $user->transform() );
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy( $id )
	{
		$user = User::find( $id );

		if( ! $user )
		{
			return $this->response( 400 );
		}	

		$user->delete();
		return $this->response( 200 );
	}

}