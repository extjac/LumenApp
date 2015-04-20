<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class AuthController extends Controller {


	public function __construct( )
	{
		$this->middleware('auth.api', [ 'except' => [ 'logIn', 'register','activation' ] ]);
	}


	/**
	 * Login
	 *
	 * @return Response
	 */
	public function logIn( Request $request )
	{

	    $v = \Validator::make( $request->only( ['email', 'password'] ), [
	        'email' 	=> 'required|email',
	        'password' 	=> 'required|min:6',
	    ]);

	    if ( $v->fails() ) 
	    {
	        return $this->response( 422, null, $v->errors() );
	    }

		 $credentials = array(
			'email'     	=> $request->input('email'),
			'password'  	=> $request->input('password'),
			'active'  		=> 1, //is active
		);
		
		if ( \Auth::attempt($credentials) )
		{		
			$user = User::find( \Auth::user()->user_id);
			$user->token =  $this->random();
			$user->save();

			return $this->response( 200, \Auth::user()->transform() );
		}
		else
		{
			return $this->response( 400 );
		}
	}


	/**
	 * Logut
	 *
	 * @return Response
	 */
	public function logOut( )
	{
		\Auth::logout();
		return $this->response( 200 );

	}

 

	/**
	 * Create new account
	 *
	 * @return Response
	 */
	public function register( Request $request )
	{

	    $v = \Validator::make( $request->only( 'email', 'password'), [
	        'email' 	=> 'required|unique:users|email',
	        'password'	=> 'required|min:8',
	    ]);

	    if ( $v->fails() ) 
	    {
	    	return $this->response( 422, null, $v->errors() );
	    }

		$user = new User;
		$user->first_name 		= $request->input('first_name');
		$user->first_name 		= $request->input('first_name');
		$user->email 			= $request->input('email');
		$user->password 		= bcrypt( $request->input('password') );
		$user->active 			= 0;
		$user->activation_token	= $this->random();
		
		if( $user->save() )
		{
			//if Mail::send() is active
			//$this->fireWelcomeMessage( $user );
		}

		return $this->response( 200, $user->transform() );
	}



	/**
	 * Create new account
	 *
	 * @return Response
	 */
	public function activation( Request $request, $token )
	{

		$user = User::findActivationToken( $token );

		if( ! $user )
		{
			return $this->response(400 );
		}	

		$user->activation_token=null;
		$user->active = 1;
		$user->save();

		return $this->response( 200 );
	}



}