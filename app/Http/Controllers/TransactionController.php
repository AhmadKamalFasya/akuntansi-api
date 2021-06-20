<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $transaction = Transaction::orderBy('time', 'DESC')->get();

      $response = [
        'message' => 'List Transaction ordered by Id',
        'data' => $transaction
      ]; 

      return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Proses validasi 
        $validator = Validator::make($request->all(), [
        'title'   => ['required'],
        'amount'  => ['required', 'numeric'],
        'type'    => ['required', 'in:expense,revenue'], 
      ]);


      // Jika gagal tampilkan error
      if ($validator->fails()) {
        return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      // Jika berhasil lakuka proses query insert
      try {
        $transaction = Transaction::create($request->all());

        $response = [
          'message' => 'Transaction Created',
          'data' => $transaction
        ];

        return response()->json($response, Response::HTTP_CREATED);
      } catch (QueryException $e) {
        return response()->json([
          'message' => "Failed " . $e->errorInfo 
        ]);
      }
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
