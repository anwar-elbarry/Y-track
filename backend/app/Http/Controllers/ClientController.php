<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    protected $clientService;

    public function __construct(ClientService $clientService){
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $clients = $this->clientService->showAll();
            if($clients){
                return response()->json([
                    'message' => 'clients fetched successfully',
                    'clients' => $clients
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(clientRequest $request)
    {

            $validateData = $request->validated();
            $validateData['user_id'] = Auth::id();

            $client = $this->clientService->create($validateData);

            if($client){
                return response()->json([
                    'message' => 'client created successfully',
                    'client' => $client
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create client',
                'user_id' => Auth::id()
            ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $clientId)
    {
        try {
            $client = $this->clientService->show($clientId);
            if($client){
                return response()->json([
                    'message' => 'client fetched seccussfully'
                ],200);
            }
            \Log::warning('Failed to fetch client', [
                'client_id' => $clientId
            ]);
            return response()->json([
                'message' => 'faild to fetch client'
            ],400);
        } catch (\Exception $e) {
            \Log::error('client Show Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $clientId
            ]);
            return response()->json([
                'message' => 'Unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(clientRequest $request,int $clientId)
    {
            $validateData = $request->validated();
            $client = $this->clientService->update($clientId,$validateData);
            if($client){
                return response()->json([
                    'message' => 'client Updated seccussfully',
                    'Updated client' => $client
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update client'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $clientId)
    {
            $isDeleted = $this->clientService->remove($clientId);
            if($isDeleted){
                return response()->json([
                    'message' => 'client Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete client'
            ],400);

    }
}
