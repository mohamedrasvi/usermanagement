<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;




class UserController extends Controller {
	
	protected $per_page;



	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		try {
			$per_page = 15;
				
			if ($request->query ( 'page' )) {
				$this->per_page = $request->query ( 'per_page' );
				$per_page = $this->per_page;

				$user = User::orderBy ( 'id', 'DESC' )->paginate ( $per_page );
			} else {
				$user = User::all ();
			}
			$checkEmptyArray = array_filter ( ( array ) $user );
			if ($checkEmptyArray) {

				return json_encode ( [
						'error' => false,
						'user' => $user
				] );
			} else {

				return json_encode ( [
						'error' => true,
						'message' => 'No result found!'
				] );
			}
		} catch ( \Exception $e ) {
			$message = array (
					'message' => $e->getMessage ()
			);
			
			return json_encode ( [
					'error' => true,
					'message' => $message
			] );
			
		}
	}

	/**
	 * Create new user.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$validator = null;


		$this->validateUserCreate ( $request );

		if ($validator != null and $validator->fails ()) {
			return $this->throwValidationException ( $request, $validator );
		}

		try {
			$user = User::create ( $request->all());
				
			return json_encode ( [
					'error' => false,
					'user' => $user
			] );
		} catch ( \Exception $e ) {
			$message = array (
					'message' => $e->getMessage ()
			);
			return json_encode ( [
					'error' => true,
					'message' => $message
			] );
		}
	}

	/**
	 * Display User resource.
	 *
	 * @param \App\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		try {
			$user = User::find ( $id );
			$checkEmptyArray = array_filter ( ( array ) $user );
			if ($checkEmptyArray) {
				return json_encode ( [
						'error' => false,
						'user' => $user
				] );
			} else {

				return json_encode ( [
						'error' => true,
						'message' => "No result found!"
				] );
			}
		} catch ( \Exception $e ) {
			$message = array (
					'message' => $e->getMessage ()
			);
			return json_encode ( [
					'error' => true,
					'message' => $message
			] );
		}
	}

	/**
	 * Update User storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
             
		//$validator = null;
		$this->validateUserUpdate ( $request );
		
		$id = $request->id;

		

		try {
			$user = User::find ( $id)->update ( $request->all());
				
			return json_encode ( [
					'error' => false,
					'message' => 'Updated successfully'
			] );
		} catch ( \Exception $e ) {
			$message = array (
					'message' => $e->getMessage ()
			);
			return json_encode ( [
					'error' => true,
					'message' => $message
			] );
		}
	}



	/**
	 * Remove the User from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request) {
		$this->validate ( $request, [

				'id' => 'required|exists:user,id'
		] );
		$id = $request->id;

		try {
			User::find ( $id)->delete ();
			return json_encode ( [
					'error' => false,
					'message' => 'Deleted specified user successfully'
			] );
		} catch ( \Exception $e ) {
			$message = array (
					'message' => $e->getMessage ()
			);
			return json_encode ( [
					'error' => true,
					'message' => $message
			] );
		}
	}

	/**
	 * Validate the user create request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return void
	 */
	protected function validateUserCreate(Request $request) {
		$this->validate ( $request, [
				'name' => 'required|string|max:30',
				'email' => 'required|string|email|max:50',
		] );
	}

	/**
	 * Validate the user update request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return void
	 */
	protected function validateUserUpdate(Request $request) {
		$this->validate ( $request, [
				'id' => 'required|exists:user,id',
				'name' => 'sometimes|required|string|max:30',
				'email' => 'sometimes|required|string|email|max:50',
		] );
	}

	

}