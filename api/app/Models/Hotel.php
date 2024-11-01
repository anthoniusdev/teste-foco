<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Hotel",
 *     title="Hotel",
 *     description="Hotel model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the hotel"
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         description="The name of the hotel"
 *     )
 * )
 */
class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['Name'];
}
