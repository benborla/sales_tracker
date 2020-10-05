<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BillingResource;
use App\Models\User\Billing;
use App\Repository\Interfaces\User\BillingRepositoryInterface;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    private $billingRepository;

    public function __construct(BillingRepositoryInterface $billingRepository)
    {
        $this->billingRepository = $billingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $billing = $this->billingRepository->paginated();
        return BillingResource::collection($billing);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        //
    }
}
