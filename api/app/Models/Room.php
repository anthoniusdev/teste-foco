<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserve;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="Room",
 *     title="Room",
 *     description="Room model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the room"
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         description="The name of the room"
 *     ),
 *     @OA\Property(
 *         property="hotelCode",
 *         type="string",
 *         description="The hotel code of the room. A foreign key to the hotels table"
 *     )
 * )
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'hotelCode'
    ];
    
    /**
     * Check if the room is available on a specific date
     */
    public function isAvailable(Carbon $date): bool
    {
        $reservesExists = Reserve::where('roomCode', $this->id)->where('CheckIn', '<=', $date)->where('CheckOut', '>=', $date)->exists();
        return !$reservesExists;
    }
}
