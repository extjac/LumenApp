<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    //rando numbers used by token
    public function random()
    {
    	return rand(1111111111, 9999999999);
    }

	/**
	 * Custom Json Reponse 
	 *
	 * @return Json Response
	 */
    function response( $code=200,  $data=null, $errors=null, $customMessage=null)
    {
    	
    	$success = false;

    	$status_code = [
    		'200' => 'OK',
    		'201' => 'Created',
    		'400' => 'Bad Request',
    		'401' => 'Unauthorized',
    		'422' => 'Unprocessable Entity',
    		'500' => 'Internal Server Error',
    	];

		if( $code==200 || $code==201 ) $success = true;

        return response( [  
            'success' 	=> isset($success) ? $success : false , 
            'code' 	=> isset($code) ? $code : 400, 
            'message'	=> isset($customMessage) ? $customMessage : $status_code[ $code ] ,
            'errors' 	=> isset($errors) ? $errors : null,
            'data' 	=> isset($data) ? $data : null
        ], $code );

    }


    public function fireWelcomeMessage( $user )
    {

        $data = [
            "body" => '<h1> Welcome </h1>'
        ];  

        Mail::send('emails.template', $data, function( $message ) use ( $user  )
        {
            $message->from( 'noReply@outlook.com' , 'noReply@outlook.com');
            $message->to( $user->email, $user->first_name )->subject( 'Welcome!' );
        });


    }


}
