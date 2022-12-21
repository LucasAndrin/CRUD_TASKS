<?php

namespace App\Http\Controllers;

use App\Services\UserCoordinatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCoordinatorController extends Controller
{
    private UserCoordinatorService $userCoordinatorService;

    public function __construct()
    {
        $this->userCoordinatorService = new UserCoordinatorService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->userCoordinatorService->getTasks($request->search);

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->userCoordinatorService->createTask($request->description, $request->user()->uuid, $request->responsible_uuid);

        return response()->json($data, 200);
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

    public function responsibles(): JsonResponse
    {
        $data = $this->userCoordinatorService->getReponsibles();

        return response()->json($data, 200);
    }
}
