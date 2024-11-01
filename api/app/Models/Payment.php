<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Payment",
 *     title="Payment",
 *     description="Payment model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the payment"
 *     ),
 *     @OA\Property(
 *         property="Method",
 *         type="string",
 *         description="The method of the payment"
 *     ),
 *     @OA\Property(
 *         property="Value",
 *         type="integer",
 *         description="The value of the payment"
 *     ),
 *     @OA\Property(
 *         property="reserveCode",
 *         type="string",
 *         description="The reserve code of the payment. A foreign key to the reserves table"
 *     )
 * )
 */
class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'Method',
        'Value',
        'reserveCode'
    ];
}
