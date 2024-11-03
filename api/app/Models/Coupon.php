<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Coupon",
 *     title="Coupon",
 *     description="Coupon model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the coupon"
 *     ),
 *     @OA\Property(
 *         property="Code",
 *         type="string",
 *         description="The code of the coupon"
 *     ),
 *     @OA\Property(
 *         property="Discount",
 *         type="number",
 *         format="float",
 *         description="The percentage of discount"
 *     ),
 *     @OA\Property(
 *         property="Validity",
 *         type="string",
 *         format="date",
 *         description="The validity of the coupon"
 *     ),
 *     @OA\Property(
 *         property="Active",
 *         type="boolean",
 *         description="If the coupon is active"
 *     ),
 *     @OA\Property(
 *         property="Limit",
 *         type="integer",
 *         description="The limit of discount" 
 *     ),
 *     @OA\Property(
 *         property="Used",
 *         type="integer",
 *         description="The number of times the coupon was used"
 *     )
 * ) 
 */
class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'Code',
        'Discount',
        'Validity',
        'Active',
        'Limit',
        'Used'
    ];
}
