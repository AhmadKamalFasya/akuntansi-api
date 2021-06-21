<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response; 


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


      $profile = Profile::orderBy('name', 'DESC')->get();

      $response = [
        'message' => 'List of Profile ordered by Id',
        'data' => $profile
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
        // Proses Validasi
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:25',
        'email' => 'email:rfc,dns'
      ]);

        // Jika gagal tampilkan error
      if($validator->fails()){
        return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

        // Jika berhasil lakukan query
      try {
        $profile = Profile::create($request->all());

        $response = [
          'message' => 'Profile Created',
          'data' => $profile
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

      $profiles = DB::table('profiles')
        ->leftJoin('transactions', 'profiles.id', '=', 'transactions.id_profiles')
        ->select('transactions.*','profiles.*')
        ->where('profiles.id', '=', $id)
        ->orderBy('profiles.created_at', 'DESC')
        ->get();

     $response = [
      'message' => 'Detail of Profile',
      'data' => $profiles
    ];

    return response()->json($response, Response::HTTP_OK);
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
