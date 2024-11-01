<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Reserve",
 *     title="Reserve",
 *     description="Reserve model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the reserve"
 *     ),
 *     @OA\Property(
 *         property="CheckIn",
 *         type="string",
 *         description="The check in date of the reserve"
 *     ),
 *     @OA\Property(
 *         property="CheckOut",
 *         type="string",
 *         description="The check out date of the reserve"
 *     ),
 *     @OA\Property(
 *         property="hotelCode",
 *         type="string",
 *         description="The hotel code of the reserve. A foreign key to the hotels table"
 *     ),
 *     @OA\Property(
 *         property="roomCode",
 *         type="string",
 *         description="The room code of the reserve. A foreign key to the rooms table"
 *     ),
 *     @OA\Property(
 *         property="guestCode",
 *         type="string",
 *         description="The guest code of the reserve. A foreign key to the guests table"
 *     ),
 *     @OA\Property(
 *         property="isPayed",
 *         type="boolean",
 *         description="The payed status of the reserve"
 *     ),
 *    @OA\Property(
 *         property="Total",
 *         type="integer",
 *         description="The total value of the reserve"
 *     )
 * )
 */
class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'CheckIn',
        'CheckOut',
        'hotelCode',
        'roomCode',
        'guestCode',
        'isPayed',
        'Total'
    ];
}
