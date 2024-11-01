<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Guest",
 *     title="Guest",
 *     description="Guest model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the guest"
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         description="The name of the guest"
 *     ),
 *     @OA\Property(
 *         property="Lastname",
 *         type="string",
 *         description="The last name of the guest"
 *     ),
 *     @OA\Property(
 *         property="Phone",
 *         type="string",
 *         description="The phone of the guest"
 *     )
 * )
 */
class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Lastname',
        'Phone'
    ];
}
