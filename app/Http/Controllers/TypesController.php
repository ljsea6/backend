<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Type;

class TypesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection. Function to add a new Type
     *
     */
    public function store(Request $request) {

        /*
         * Asignando los valores del Request a la variable $values
         */
        $values = [
            'type_id' => ($request['type_id']) ? $request['type_id'] : null,
            'name' => $request['name']
        ];

        /*
         * Verificar si el campo type_id no existe o es nullo
         */
        if (!($values['type_id'])  || ($values['type_id']) == null) {

            /*
             * Renderizando mensajes de errores de validacion
             */
            $messages = [
                'name.required' => 'El nombre es requerido',
                'name.string' => 'El nombre debe ser un carácter'
            ];

            /*
             * Validaciones de los campos a ingresar
             */
            $validator = Validator::make($values, [
                'name' => 'required|string'
            ], $messages);

            if ($validator->fails()) {
                $collect = collect($validator->messages());
                return response()->json([
                    'data' => $collect
                ]);
            }

            /*
             * Médoto para insertar en la tabla Type
             */
            $type = new Type();
            $type->name = $values['name'];
            $result = $type->save();

            /*
             * Si se insertó la información envía este mensaje cómo respuesta
             */
            if($result) {
                return response()->json([
                    'data' => [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'OK'
                    ]
                ]);
            } {
                return response()->json([
                    'data' => [
                        'status' => 'error',
                        'code' => 404,
                        'error' => 'Error to add the information'
                    ]
                ]);
            }

        } else {
            /*
             * Renderizando mensajes de errores de validacion
             */
            $messages = [
                'type_id.required' => 'El código es requerido',
                'name.required' => 'El nombre es requerido',
                'type_id.integer' => 'El código debe ser un número',
                'type_id.exists' => 'El código a ingresar no existe',
                'name.string' => 'El nombre debe ser un carácter',
            ];

            /*
             * Validaciones de los campos a ingresar
             */
            $validator = Validator::make($values, [
                'type_id' => 'required|int|exists:types,id',
                'name' => 'required|string'
            ], $messages);

            /*
             * Si hay errores se muestran
             */
            if ($validator->fails()) {
                $collect = collect($validator->messages());
                return response()->json([
                    'data' => $collect
                ]);
            }

            /*
             * Médoto para insertar en la tabla Type
             */
            $type = new Type();
            $type->name = $values['name'];
            $type->type_id = (int)$values['type_id'];
            $result = $type->save();

            /*
             * Si se insertó la información envía este mensaje cómo respuesta
             */
            if($result) {
                return response()->json([
                    'data' => [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'OK'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'status' => 'error',
                        'code' => 404,
                        'error' => 'Error to add the information'
                    ]
                ]);
            }

        }
    }
}
