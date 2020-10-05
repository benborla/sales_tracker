<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
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
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
