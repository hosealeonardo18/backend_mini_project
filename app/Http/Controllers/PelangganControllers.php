<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PelangganControllers extends Controller
{
    public function index()
    {
        try {
            $page = request()->input('page', 1);
            $limit = request()->input('limit', 50);
            $order = request()->input('orderBy', 'nama');
            $sort = request()->input('sort', 'ASC');
            $offset = ($page - 1) * $limit;
            $search = request('search');

            $pelanggan = Pelanggan::query();

            if (!empty($search)) {
                $pelanggan->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('domisili', 'like', '%' . $search . '%')
                        ->orWhere('jenis_kelamin', 'like', '%' . $search . '%');
                });
            }

            $dbPelanggan = $pelanggan->orderBy($order, $sort)
                ->when($limit !== -1, function ($q) use ($offset, $limit) {
                    $q->skip($offset)->take($limit);
                })->get();


            $countData = $pelanggan->count();

            $totalData = $countData;
            $totalPage = ceil($totalData / $limit);

            $pagination = [
                'currentPage' => $page,
                'limit' => $limit,
                'totalData' => $totalData,
                'totalPage' => $totalPage
            ];

            return handleResponse($dbPelanggan, false, 200, 'Succesfully get data pelanggan.', $pagination);
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $handleValidator = $this->handleValidate($data);

            if ($handleValidator->fails()) {
                $errorMessage = $handleValidator->errors()->first();
                throw new Exception($errorMessage, 422);
            }

            $payload = [
                "uid" => getUid(),
                "nama" => strtoupper($data["nama"]),
                "domisili" => strtoupper($data["domisili"]),
                "jenis_kelamin" => $data["jenis_kelamin"],
            ];

            $pelanggan = Pelanggan::create($payload);

            DB::commit();
            return handleResponse($pelanggan, false, 201, 'Succesfully create data pelanggan.');
        } catch (Exception $e) {
            DB::rollBack();
            return handleErrorException($e);
        }
    }

    public function show(string $uid)
    {
        try {
            $pelanggan = Pelanggan::where('uid', $uid)->first();
            if (!$pelanggan) throw new Exception('Data pelanggan not found', 404);

            return handleResponse($pelanggan, false, 200, 'Succesfully get detail data pelanggan.');
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $pelanggan = Pelanggan::where('uid', $uid)->first();
            if (!$pelanggan) throw new Exception('Data pelanggan not found', 404);

            $currents = ["nama", "domisili", "jenis_kelamin"];

            $payload = [];
            foreach ($currents as $current) {
                if (strtolower($request[$current]) != strtolower($pelanggan->$current)) {
                    $payload[$current] = strtoupper($request[$current]);

                    if ($current == "jenis_kelamin") {
                        $payload[$current] = $request[$current];
                    }
                }
            }

            $pelanggan->update($payload);

            return handleResponse($payload, false, 201, "Succesfully update data $pelanggan->nama.");
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function destroy(string $uid)
    {
        try {
            $pelanggan = Pelanggan::where('uid', $uid)->first();
            if (!$pelanggan) throw new Exception('Data pelanggan not found', 404);

            $pelanggan->delete();
            return handleResponse(null, false, 201, "Succesfully delete data.");
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function handleValidate($data)
    {
        $validator = Validator::make($data, [
            "nama" => "required|string",
            "domisili" => "required|string",
            "jenis_kelamin" => "required|string",
        ]);

        return $validator;
    }
}
