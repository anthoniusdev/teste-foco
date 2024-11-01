<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Daily",
 *     title="Daily",
 *     description="Daily model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the daily"
 *     ),
 *     @OA\Property(
 *         property="Date",
 *         type="string",
 *         description="The date of the daily"
 *     ),
 *     @OA\Property(
 *         property="Value",
 *         type="integer",
 *         description="The value of the daily"
 *     ),
 *     @OA\Property(
 *         property="reserveCode",
 *         type="string",
 *         description="The reserve code of the daily. A foreign key to the reserves table"
 *     )
 * )
 */
class Daily extends Model
{
    use HasFactory;
    protected $table = "dailies";
    protected $fillable = [
        'Date',
        'Value',
        'reserveCode'
    ];
}
