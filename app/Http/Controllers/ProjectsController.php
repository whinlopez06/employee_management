<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; //
use Response; // use response class when using ajax
use Illuminate\Support\Facades\Input;

use App\Project;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        //dd($projects);
        return view('projects.index', compact('projects'));
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

        /*$validator = Validator::make(Input::all(), [
            'code' => ['required'],
            'description' => ['required']
        ]);*/

        // imported Validator class from above
        $validator = Validator::make($request->all(), [
            'code' => ['required'],
            'description' => ['required']
        ]);

        // from the class validator 
        if($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
        }else{
            $project = new Project();   // init new object
            $project->code = $request->code;
            $project->description = $request->description;
            $project->save();
            return response()->json($project);  // encode to json
        }
        //return Response::json(array('test' => 'response test'));
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
        //return "id:".$id;
        //return $request;
        $project = Project::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => ['required'],
            'description' => ['required']
        ]);


        if($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
        }else{

            $project->code = $request->code;
            $project->description = $request->description;

            //$project->update($request->all());
            $project->save();
            return response()->json($project);  // encode to json
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
