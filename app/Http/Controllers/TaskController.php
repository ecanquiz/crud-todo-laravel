<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Array
    {
        $tasks = Task::all()->toArray();
        return array_reverse($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {    
        /*$task = Task::create([              
            'title' => $request->input('title'),
            'description' => $request->input('description')       
        ]);*/
    
        $task = new Task([
            'title' => $request->title,
            'description' => $request->description
        ]);
        $task->save(); 
        $task->refresh();
        
        return response()->json([
            "taskId" => $task->id,
            "message"=> "The task successfully stored"
        ], 201);
    }    

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        return  response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        // $task->update($request->all());
        $task->title = $request->title;
        $task->description = $request->description;
        $task->done = $request->done;
        $task->save();

        return response()->json(["message"=> "The task successfully updated"], 200);
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //Task::destroy($task->id);
        $task->delete();        
 
        return response()->json([], 204);
    }
    
}
