<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarea = Task::all();

        $data=[
            'message'=>'estas son todas las tareas',
            'tarea'=>$tarea,
            'status'=>200
        ];

        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'Tarea'=>'required',
            'Descripcion'=>'required',
            'Estado'=>'required|in:pendiente,completada,pospuesta,cancelada',
            'Prioridad'=>'required|in:alta,media,baja',
            'Fecha_limite'=>'required',
        ]);
        if($validator->fails()){
            $data=[
            'message'=>'error en la validacion de los datos',
            'errors'=>$validator->errors(),
            'status'=>400,
            ];
            return response()->json($data,400);
        }


        $dat_tareas=Task::create([
            'Tarea'=>$request->Tarea,
            'Descripcion'=>$request->Descripcion,
            'Estado'=>$request->Estado,
            'Prioridad'=>$request->Prioridad,
            'Fecha_limite'=>$request->Fecha_limite,
        ]);
        if (!$dat_tareas) {
            $data=[
                'message'=>'error al crear la tarea',
                'status'=>500,
            ];
            return response()->json($data,500);
        }


        $data=[
            'tasks'=>$dat_tareas,
            'status'=>201
        ];
        return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task_1=Task::find($id);

        if(!$task_1){
            $data=[
                'message'=>'no se encontro la tarea',
                'status'=>404,
            ];
            return response()->json($data,404);
        }

        $data=[
            'tasks'=>$task_1,
            'status'=>200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $task_up_1=Task::find($id);

        if(!$task_up_1){
            $data=[
                'message'=>'no se encontro la tarea',
                'status'=>404,
            ];
            return response()->json($data,404);
        }

        $validate_up_1=Validator::make($request->all(),[
            'Tarea'=>'',
            'Descripcion'=>'',
            'Estado'=>'in:pendiente,completada,pospuesta,cancelada',
            'Prioridad'=>'in:alta,media,baja',
            'Fecha_limite'=>'',

        ]);

        if($validate_up_1->fails()){
            $data=[
                'message'=>'no se pudo editar',
                'errors'=>$validate_up_1->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);
        }

        if($request->has('Tarea')){
            $task_up_1->Tarea=$request->Tarea;
        }
        if($request->has('Descripcion')){
            $task_up_1->Descripcion=$request->Descripcion;
        }
        if($request->has('Estado')){
            $task_up_1->Estado=$request->Estado;
        }
        if($request->has('Prioridad')){
            $task_up_1->Prioridad=$request->Prioridad;
        }
        if($request->has('Fecha_limite')){
            $task_up_1->Fecha_limite=$request->Fecha_limite;
        }

        $task_up_1->save();

        $data=[
            'message'=>'tarea editada',
            'tasks'=>$task_up_1,
            'status'=>200,
        ];
        return response()->json($data,200);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task_update=Task::find($id);

        if(!$task_update){
            $data=[
                'message'=>'no se encontro la tarea',
                'status'=>404,
            ];
            return response()->json($data,404);
        }

        $validate_task=Validator::make($request->all(),[
            'Tarea'=>'required',
            'Descripcion'=>'required',
            'Estado'=>'required|in:pendiente,completada,pospuesta,cancelada',
            'Prioridad'=>'required|in:alta,media,baja',
            'Fecha_limite'=>'required',
        ]);

        if($validate_task->fails()){
            $data=[
                'message'=>'error en la validacion de los datos',
                'errors'=>$validate_task->errors(),
                'status'=>404,
            ];
            return response()->json($data,404);
        }

        $task_update->Tarea=$request->Tarea;
        $task_update->Descripcion=$request->Descripcion;
        $task_update->Estado=$request->Estado;
        $task_update->Prioridad=$request->Prioridad;
        $task_update->Fecha_limite=$request->Fecha_limite;
        $task_update->save();

        $data=[
            'message'=>'tarea actualizada',
            'status'=>200,
        ];
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task_destroy=Task::find($id);

        if(!$task_destroy){
            $data=[
                'message'=>'no se encontro la tarea',
                'status'=>404,
            ];
            return response()->json($data,404);
        }

        $task_destroy->delete();

        $data=[
            'message'=>'tarea eliminada',
            'status'=>200
        ];
        return response()->json($data,200);
    }
}
