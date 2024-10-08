<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangControllers extends Controller
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

            $barang = Barang::query();

            if (!empty($search)) {
                $barang->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('harga', 'like', '%' . $search . '%');
                });
            }

            $dbBarang = $barang->orderBy($order, $sort)
                ->when($limit !== -1, function ($q) use ($offset, $limit) {
                    $q->skip($offset)->take($limit);
                })->get();


            $countData = $barang->count();

            $totalData = $countData;
            $totalPage = ceil($totalData / $limit);

            $pagination = [
                'currentPage' => $page,
                'limit' => $limit,
                'totalData' => $totalData,
                'totalPage' => $totalPage
            ];

            return handleResponse($dbBarang, false, 200, 'Succesfully get data barang.', $pagination);
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

            $kategory = $request->kategori;
            $number = 1;

            $kodeBarang = strtolower($kategory) . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

            while (Barang::where('kode', $kodeBarang)->exists()) {
                $number++;

                $kodeBarang = strtolower($kategory) . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }

            $payload = [
                "kode" => $kodeBarang,
                "nama" => strtoupper($request->nama),
                "kategori" => strtoupper($request->kategori),
                "harga" => $request->harga,
            ];

            $barang = Barang::create($payload);

            DB::commit();
            return handleResponse($barang, false, 201, 'Succesfully create data barang.');
        } catch (Exception $e) {
            DB::rollBack();
            return handleErrorException($e);
        }
    }

    public function show(string $kode)
    {
        try {
            $barang = Barang::where('kode', $kode)->first();
            if (!$barang) throw new Exception('Data barang not found', 404);

            return handleResponse($barang, false, 200, 'Succesfully get detail data barang.');
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function update(Request $request, string $kode)
    {
        try {
            $barang = Barang::where('kode', $kode)->first();
            if (!$barang) throw new Exception('Data barang not found.', 404);

            $currents = ['nama', 'kategori', 'harga'];

            $payload = [];
            foreach ($currents as $current) {
                if (strtolower($request[$current]) != strtolower($barang->$current)) {
                    $payload[$current] = strtoupper($request[$current]);
                }
            }

            if (!empty($payload)) {
                $barang->update($payload);
            } else {
                return handleResponse(null, false, 200, 'No item data updated.');
            }

            return handleResponse($payload, false, 201, 'Succesfully update data barang.');
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function destroy(string $kode)
    {
        try {
            $barang = Barang::where('kode', $kode)->first();
            if (!$barang) throw new Exception('Data barang not found', 404);

            $barang->delete();
            return handleResponse(null, false, 201, "Succesfully delete data.");
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function handleValidate($data)
    {
        $validator = Validator::make($data, [
            "nama" => "required|string",
            "kategori" => "required|string",
            "harga" => "required|numeric",
        ]);

        return $validator;
    }
}
