<?php

namespace App\Http\Controllers;

use App\Contracts\CurrencyConversionInterface;
use App\Http\Requests\StoreUserRequest;
use App\Models\Currency;
use App\Models\User;
use App\Services\ExternalCurrencyConversionService;
use App\Services\LocalCurrencyConversionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class UserController extends Controller
{
    private LoggerInterface $logger;
    private CurrencyConversionInterface $currencyConversionService;

    public function __construct(
        ExternalCurrencyConversionService $externalCurrencyConversionService,
        LocalCurrencyConversionService $localCurrencyConversionService,
        LoggerInterface $logger
    )
    {
        if (env('EXTERNAL_CONVERSION_API')) {
            $this->currencyConversionService = $externalCurrencyConversionService;
        } else {
            $this->currencyConversionService = $localCurrencyConversionService;
        }

        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     *
     * @returns Response
     */
    public function index()
    {
        $users = User::all();
        $currencies = Currency::all();

        return view('user', [ 'users' => $users, 'currencies' => $currencies ]);
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
     * @param  string  $id
     * @param  string  $currency
     * @return JsonResponse
     */
    final public function showRateByCurrency(string $id, string $currency): JsonResponse
    {
        $user = User::where('id', $id)->first();
        $usersCurrency = Currency::where('id', $user->rate->currency_id)->first()->currency;

        try {
            $convertedHourlyRate = $this->currencyConversionService->convertHourlyRateToCurrency(
                $user->rate->hourly,
                $usersCurrency,
                $currency
            );

            return response()->json(
                [
                    'User' => [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'contact_number' => $user->contact_number,
                        'Rate' => [
                            'currency' => $currency,
                            'hourly_rate' => $convertedHourlyRate
                        ]
                    ]
                ]
            );

        } catch (\Exception $e) {
             $this->logger->error([ 'Server error with external api',
                 'Error ' => 'Api connection error',
                 'Message' => $e->getMesssage()
             ]);
        }
    }
}
