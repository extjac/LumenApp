<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {


	use Authenticatable, CanResetPassword;



	public $primaryKey = 'user_id';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'created_at','updated_at'];


	protected $guarded = [];


	/**
	* Return all users
	*/
	public static function findAll()
	{
		return User::select( 'users.user_id', 'users.first_name', 'users.last_name',  'users.email' )
		->active()
		->get();
	}


	/**
	* Return user 
	*/
	public static function findByEamil( $email )
	{
		return User::where('email', $email)
		->first();
	}


	/**
	* Return user to be activated
	*/
	public static function findActivationToken( $token )
	{
		return User::where('activation_token', $token)
		->where('active',0)
		->first();
	}






	public function scopeActive($query)
	{
	    $query->where('active', '=', 1);
	}



	public function transform()
	{
		return [
				"user_id" => (int) $this->user_id,
				"token" => (int) $this->token,
				"active" => (int) $this->active,
				"first_name" => $this->first_name,
				"last_name" => $this->last_name,
				"name" => $this->name,
				"username" => $this->username,
				"email" => $this->email,
				"address" => $this->address,
				"address1" => $this->address1,
				"city" => $this->city,
				"zipcode" => $this->zipcode,
				"state" => (int) $this->state,
				"country" => $this->country,
				"primary_phone" => $this->primary_phone,
				"secondary_phone" => $this->secondary_phone,
			];
	}



}
