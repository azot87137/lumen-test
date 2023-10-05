<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    protected $service;

    /**
     * @param CompanyService $service
     */
    public function __construct(CompanyService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return $this->successResponse($this->service->getUserCompanies($user->id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $company = $this->service->create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
        ]);

        return $this->successResponse($company, 201);
    }
}
