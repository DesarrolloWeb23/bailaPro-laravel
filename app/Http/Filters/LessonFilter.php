<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

/**
 * Clase base para manejar los filtros en solicitudes http
 * @author Juan U.
 * @method array transform(Request $request)
 */
class LessonFilter extends ApiFilter
{

    protected $safeParams   = [
        'id'    => ['eq', 'ne'],
        'name'  => ['eq', 'ne', 'lk'],
        'description' => ['eq', 'ne', 'lk'],
        'duration' => ['eq', 'ne'],
        'shedule' => ['eq', 'ne'],
        'capacity' => ['eq', 'ne'],
        'start_date' => ['eq', 'ne'],
        'end_date' => ['eq', 'ne'],
        'academy_id' => ['eq', 'ne'],
        'status' => ['eq', 'ne'],
    ]; //Parametros para filtros de modelos
    protected $columMap     = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'duration' => 'duration',
        'shedule' => 'shedule',
        'capacity' => 'capacity',
        'start_date' => 'start_date',
        'end_date' => 'end_date',
        'academy_id' => 'academy_id',
        'status' => 'state_id',
    ]; //Mapea las columnas a como queremos que se filtren

    /**
     *eq:  Equal                 (=).  Significa "igual a".
     *lt:  Less Than             (<).  Significa "menor que".
     *lte: Less Than or Equal    (<=). Significa "menor o igual que".
     *gt:  Greater Than          (>).  Significa "mayor que".
     *gte: Greater Than or Equal (>=). Significa "mayor o igual que".
     *ne:  Not Equal             (!=). Significa "no igual a".
     */
    protected $operatorMap  = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',
        'lk' => 'like',
    ]; //Creamos los mapeos de operadores
}
