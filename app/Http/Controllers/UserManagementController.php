<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;   // import the User model
use Auth;   // add authentication class or include in your constructor
use Validator; // class for validation 
use Response; // use response class when using ajax
use Illuminate\Support\Facades\DB;  // you can use db query
use Illuminate\Support\Facades\Input;

class UserManagementController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->username);

        //implement pagination. 10 records per page
        $users = User::paginate(10);  //$users = User::all();  // laravel eloquent
        //dd($users);

        // $users = User::where('id', '>=', 2)->get();

        // $users = DB::table('Users')->latest()->get();   // laravel query builder


        

        // return view('users-mgmt.index', compact('users'));
        return view('users-mgmt.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->getInputRules());
        
        if($validator->fails()){
            /* dd(Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toarray()
            ), 400)
            ); */

            // dd(array('errors' => $validator->getMessageBag()->toarray()));
            //Response::json
            return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toarray()
                ), 400); // 400 being the HTTP code for an invalid request.
        }

        // save then return reponse
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->save();

        //* return response()->json($user);
        return response()->json(array(
                'success' => true,
                'data' => $user,
                'message' => 'User created successfully'
            ), 200 );
        
        //return Response::json(array('success' => true), 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), $this->getInputRules());

        if($validator->fails()){
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toarray()
            ), 503); // set response code - 503 service unavailable
        }

        // save then return reponse
        //$user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->update();
        
        return response()->json(array(
            'success' => true,
            'data' => $user,
            'message' => 'User updated successfully'
        ), 200);

        /**
         * DB::table('users')
            ->where('id', 1)
            ->update(['votes' => 1]);
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // User::where('id', $id)->delete();
        $user = User::findOrFail($id)->delete();
   
        if($user){
            return response()->json(array(
                'success' => true,
                'message' => 'User deleted successfully'
            ), 200 );
        }else {
            return response()->json(array(
                'success' => false,
                'message' => 'Failed to delete user.'
            ), 503);
        }
    }

    /**
     * Search user from database base on some specific constraints
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $constraints = [
            'search_username' => $request['search_username'],
            'search_email' => $request['search_email'],
            'search_firstname' => $request['search_firstname'],
            'search_lastname' => $request['search_lastname']
        ];
        
        $users = $this->doSearchingQuery($constraints);
        //dd($users->get());
        return view('users-mgmt.index', ['users' => $users, 'searchingVals' => $constraints]);

    }

    public function doSearchingQuery($constraints){
        $query = User::query(); // query builder
        //dd($query);
        $fields = array_keys($constraints);
       
        $index = 0;

        foreach($constraints as $constraint){
            // check each array value if not empty
            if(!empty($constraint)){
                // append every where clause in the query builder object 
                $query = $query->where(str_replace('search_', '', $fields[$index]), 'LIKE', '%' . $constraint . '%');    
            }
            $index++;
        }
        //dd($query->get());
        return $query->paginate(10)->setPath('');
    }

    public function getInputRules() : array {
        // create rules for the input
         return array(
            'username' => 'required|min:3|max:50',
            'email' => 'required|min:3|max:50',
            'password' => 'required|min:5',
            'password_confirm' => 'required_with:password|same:password|min:5',
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50'
        );
    }

}
