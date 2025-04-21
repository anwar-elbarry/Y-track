<?php

namespace App\Http\Controllers;
use App\Http\Requests\BillRequest;
use App\Services\BillService;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService){
        $this->billService = $billService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $bills = $this->billService->showAll();
            if($bills){
                return response()->json([
                    'message' => 'bills fetched successfully',
                    'bills' => $bills
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $request)
    {

            $validateData = $request->validated();
            $validateData['user_id'] = Auth::id();

            $bill = $this->billService->create($validateData);

            if($bill){
                return response()->json([
                    'message' => 'bill created successfully',
                    'bill' => $bill
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create bill',
                'user_id' => Auth::id()
            ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $billId)
    {
            $bill = $this->billService->show($billId);
            if($bill){
                return response()->json([
                    'message' => 'bill fetched seccussfully'
                ],200);
            }

            return response()->json([
                'message' => 'faild to fetch bill'
            ],400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillRequest $request,int $billId)
    {
            $validateData = $request->validated();
            $bill = $this->billService->update($billId,$validateData);
            if($bill){
                return response()->json([
                    'message' => 'bill Updated seccussfully',
                    'Updated bill' => $bill
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update bill'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $billId)
    {
            $isDeleted = $this->billService->remove($billId);
            if($isDeleted){
                return response()->json([
                    'message' => 'bill Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete bill'
            ],400);

    }
    public function destroyMultiple(array $billsId)
    {

            $billsCount = count($billsId);
            $isDeleted = $this->billService->removeMultiple($billsId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$billsCount} bill Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete bill'
            ],400);
    }
}
