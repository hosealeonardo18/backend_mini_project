<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanControllers extends Controller
{
    public function index()
    {
        try {
            $page = request()->input('page', 1);
            $limit = request()->input('limit', 20);
            $order = request()->input('orderBy', 'id_nota');
            $sort = request()->input('sort', 'DESC');
            $offset = ($page - 1) * $limit;
            $search = request('search');

            $filterByPelanggan = request('pelanggan');
            $filterByKategoriBarang = request('kategori');
            $penjualan = Penjualan::query();

            if (!empty($search)) {
                $penjualan->where(function ($query) use ($search) {
                    $query->where('id_nota', 'like', '%' . $search . '%');
                });
            }

            // Filter berdasarkan pelanggan
            if (!empty($filterByPelanggan) && !empty($filterByKategoriBarang)) {
                // Gabungkan filter pelanggan dan kategori barang dengan logika OR
                $penjualan->where(function ($query) use ($filterByPelanggan, $filterByKategoriBarang) {
                    $query->whereHas('pelanggan', function ($query) use ($filterByPelanggan) {
                        $query->where('uid', $filterByPelanggan);
                    })->orWhereHas('itemPenjualan.barang', function ($query) use ($filterByKategoriBarang) {
                        $query->where('kategori', $filterByKategoriBarang);
                    });
                });
            } elseif (!empty($filterByPelanggan)) {
                // Jika hanya filter pelanggan yang ada
                $penjualan->whereHas('pelanggan', function ($query) use ($filterByPelanggan) {
                    $query->where('uid', $filterByPelanggan);
                });
            } elseif (!empty($filterByKategoriBarang)) {
                // Jika hanya filter kategori barang yang ada
                $penjualan->whereHas('itemPenjualan.barang', function ($query) use ($filterByKategoriBarang) {
                    $query->where('kategori', $filterByKategoriBarang);
                });
            }

            $dbPenjualan = $penjualan->with('itemPenjualan', 'pelanggan')
                ->orderBy($order, $sort)
                ->when($limit !== -1, function ($q) use ($offset, $limit) {
                    $q->skip($offset)->take($limit);
                })->get();


            $countData = $penjualan->count();

            $totalData = $countData;
            $totalPage = ceil($totalData / $limit);

            $pagination = [
                'currentPage' => $page,
                'limit' => $limit,
                'totalData' => $totalData,
                'totalPage' => $totalPage
            ];

            return handleResponse($dbPenjualan, false, 200, 'Succesfully get data penjualan.', $pagination);
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

            $number = 1;
            $thisYear = Carbon::now()->format('Ymd');
            $nota = $thisYear . str_pad($number, 6, '0', STR_PAD_LEFT);

            while (Penjualan::where('id_nota', $nota)->exists()) {
                $number++;

                $nota = $thisYear . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            $payload = [
                "id_nota" => $nota,
                "kode_pelanggan" => $request->kode_pelanggan,
                "subtotal" => 0,
            ];

            $penjualan = Penjualan::create($payload);

            $subtotal = 0;
            $barangs = $request->barang;
            if (!empty($barangs)) {
                foreach ($barangs as $item) {
                    $checkBarang = Barang::where('kode', $item['kode'])->first();
                    if (!$checkBarang) throw new Exception('Data barang not found.', 404);

                    $payloadItem = [
                        "id_nota" => $nota,
                        "kode_barang" => $checkBarang->kode,
                        "qty" => $item['qty'],
                    ];

                    ItemPenjualan::create($payloadItem);

                    $total = $checkBarang->harga * $item['qty'];
                    $subtotal += $total;
                }

                $penjualan->update(['subtotal' => $subtotal]);
                DB::commit();

                return handleResponse($penjualan, false, 201, 'Succesfully create data penjualan.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return handleErrorException($e);
        }
    }

    public function show(string $nota)
    {
        try {
            $penjualan = Penjualan::where('id_nota', $nota)->with('pelanggan', 'itemPenjualan')->first();
            if (!$penjualan) throw new Exception('Data penjualan not found', 404);

            return handleResponse($penjualan, false, 200, 'Succesfully get detail data penjualan.');
        } catch (Exception $e) {
            return handleErrorException($e);
        }
    }

    public function update(Request $request, string $nota)
    {
        //
    }

    public function destroy(string $nota)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::where('id_nota', $nota)->with('itemPenjualan')->first();
            if (!$penjualan) throw new Exception('Data penjualan not found', 404);

            $itemPenjualan = $penjualan->itemPenjualan();

            if (!empty($itemPenjualan) && $itemPenjualan->count() > 0) $itemPenjualan->delete();

            $penjualan->delete();
            DB::commit();

            return handleResponse(null, false, 201, "Succesfully delete data penjualan.");
        } catch (Exception $e) {
            DB::rollBack();
            return handleErrorException($e);
        }
    }

    public function handleValidate($data)
    {
        $validator = Validator::make($data, [
            "kode_pelanggan" => "required|string",
        ]);

        return $validator;
    }
}
