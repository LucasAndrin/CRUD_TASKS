<?php

namespace App\Http\Controllers;

use App\Services\UserResponsibleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserResponsibleController extends Controller
{
    private UserResponsibleService $userResponsibleService;

    public function __construct()
    {
        $this->userResponsibleService = new UserResponsibleService;
    }

    public function index(Request $request): JsonResponse
    {
        $data = $this->userResponsibleService->getTasks($request->user()->uuid, $request->search);

        return response()->json($data, 200);
    }

    public function markAsProgress(Request $request): JsonResponse
    {
        $data = $this->userResponsibleService->markTaskAsProgress($request->uuid);

        return response()->json($data, 200);
    }

    public function markAsStopped(Request $request): JsonResponse
    {
        $data = $this->userResponsibleService->markAsStopped($request->uuid);

        return response()->json($data, 200);
    }

    public function markAsCompleted(Request $request): JsonResponse
    {
        $data = $this->userResponsibleService->markTaskAsCompleted($request->uuid);

        return response()->json($data, 200);
    }
}
