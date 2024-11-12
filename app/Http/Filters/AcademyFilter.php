<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

/**
 * Clase base para manejar los filtros en solicitudes http
 * @author Juan U.
 * @method array transform(Request $request)
 */
class AcademyFilter extends ApiFilter
{
    protected $safeParams   = [
        'id'    => ['eq', 'ne'],
        'name'  => ['eq', 'ne', 'lk'],
        'description' => ['eq', 'ne', 'lk'],
        'state' => ['eq', 'ne'],
        'address' => ['eq', 'ne', 'lk'],
        'phone' => ['eq', 'ne', 'lk'],
        'email' => ['eq', 'ne', 'lk'],
        'rating' => ['eq', 'ne'],
    ]; //Parametros para filtros de modelos
    protected $columMap     = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'state' => 'state_id',
        'address' => 'address',
        'phone' => 'phone',
        'email' => 'email',
        'rating' => 'rating',
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
