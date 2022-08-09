<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'first_name', 'last_name', 'dob', 'contact_number', 'profession'
    ];

    protected $dates = ['created_at', 'updated_at'];

    final public function rate(): HasOne
    {
        return $this->hasOne(Rate::class);
    }

    /**
     * @note : I'd normally create a UserRepository and put this
     *          method in there instead of the model, but im not going
     *          to hook up a repository service for the sake of saving time.
     *
     * @param  array  $attributes
     * @return string|Application|Factory|View
     */
    public static function saveUser(array $attributes): User|string
    {
        try {
            DB::beginTransaction();

            $user = new User;
            $user->first_name = $attributes['first_name'];
            $user->last_name = $attributes['last_name'];
            $user->dob = $attributes['dob'];
            $user->contact_number = $attributes['contact_number'];
            $user->profession = $attributes['profession'];
            $user->created_at = Carbon::createFromFormat('Y-m-d H:i:s', now());
            $user->save();

            $rate = new Rate;

            $rate->user_id = $user->id;
            $rate->hourly = $attributes['rate'];
            $rate->currency_id = $attributes['currency'];
            $rate->created_at = Carbon::createFromFormat('Y-m-d H:i:s', now());
            $rate->save();

            DB::commit();

            return $user;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
