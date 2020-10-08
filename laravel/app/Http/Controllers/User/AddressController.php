<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Models\User\Address;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\AddressResource;
use App\Repository\Interfaces\User\AddressRepositoryInterface;

class AddressController extends Controller
{
    private $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $address = $this->addressRepository->getAllFromUser($user->id);
        return AddressResource::collection($address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $address = $this->addressRepository->add($user, $request->all());
        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, int $id)
    {
        $address = $this->addressRepository->find($id);

        return new AddressResource($address);
    }

    public function showShipping(User $user)
    {
        $address = $this->addressRepository->getOneByAddresType($user->id, Address::TYPE_SHIPPING);

        return new AddressResource($address);
    }

    public function showBilling(User $user)
    {
        $address = $this->addressRepository->getOneByAddresType($user->id, Address::TYPE_BILLING);

        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, int $id)
    {
        $address = $this->addressRepository->update($id, $request->all());

        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, int $id)
    {
        return new JsonResponse(['deleted' => $this->addressRepository->delete($id)]);
    }
}
