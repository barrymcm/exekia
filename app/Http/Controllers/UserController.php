<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @returns Response
     */
    public function index()
    {
        $users = User::all();

        return view('user', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    final public function create(): Application|Factory|View
    {
        $currencies = Currency::all();

        return view('users.create', ['currencies' => $currencies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return string|Application|Factory|View
     */
    public function store(StoreUserRequest $request): string|Application|Factory|View
    {
        $attributes = $request->validated();
        $user = User::saveUser($attributes);

        return view('users.show', [
                'user' => $user,
                'currencies' => Currency::all()
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    final public function show(int $id)
    {
        $user = User::where('id', $id)->first();
        $currencies = Currency::all();

        // Hack - This ($user->rate->currency->currency) wont work ...
        // so im just doing it this way to get it done.
        $currency = Currency::where('currency_id', $user->rate->currency_id)->first();

        return view('users.show', [
            'user' => $user,
            'currency' => $currency,
            'currencies' => $currencies
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
