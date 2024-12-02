<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Arrival;
use App\Models\Output;
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\Travel;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function updateSend($travel_id)
    {
        try {
            $travel = Travel::where('id_travel', '=', $travel_id)->first();

            if (!$travel) {
                return response()->json([
                    'message' => 'Viagem não encontrada.',
                ], 404);
            }

            $travel->update(['sent' => true]);

            return response()->json([
                'message' => 'Status de envio atualizado com sucesso.',
                'travel' => $travel,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getTravel($travel_id)
    {
        try {
            $travel = Travel::where('id_travel', $travel_id)
                ->with(['arrival', 'output', 'package'])
                ->first();

            return response()->json([
                'travel' => $travel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTravelArrivalOutput()
    {
        try {
            $travel = Travel::where('sent', '=', 0)
                ->with(['arrival', 'output'])->get();
            return response()->json([
                'travel' => $travel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendPack(Request $request, $user_id): JsonResponse
    {
        try {
            $travel = Travel::where('user_id', '=', $user_id)
                ->where('sent', '=', 1)
                ->with(['arrival', 'output', 'package'])->get();

            if ($travel->isEmpty())
            {
                return response()->json([
                    'message' => 'Pacotes não encontrados!',
                ]);
            }

            $bearerToken = $request->bearerToken();
            $client = new Client();

            $travel->map(function ($travel_info) use ($client, $bearerToken) {
                if (isset($travel_info->id_travel)) {
                    try {
                        $response = $client->request('GET', 'http://54.205.181.130:84/api/proposal/' . $travel_info->id_travel . '/travel', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $bearerToken,
                                'Accept' => 'application/json',
                            ],
                        ]);
                        if ($response->getStatusCode() == 200) {
                            $user = json_decode($response->getBody(), true);
                            $travel_info->user = $user;
                        } else {
                            $travel_info->user = ['error' => 'Usuário não encontrado'];
                        }
                    } catch (\Exception $e) {
                        $travel_info->user = ['error' => 'Falha ao buscar o usuário'];
                        \Log::error("Erro ao carregar usuário: {$e->getMessage()}");
                    }
                } else {
                    $travel_info->user = null;
                }
            });

            return response()->json([
                'message' => 'Pacotes enviados!',
                'travel' => $travel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function unsendPack($user_id): JsonResponse
    {
        try {
            $travel = Travel::where('user_id', '=', $user_id)
                ->where('sent', '=', 0)
                ->with(['arrival', 'output', 'package'])->get();

            if ($travel->isEmpty())
            {
                return response()->json([
                    'message' => 'Pacotes não encontrados!',
                ]);
            }
            return response()->json([
                'message' => 'Pacotes não enviados!',
                'travel' => $travel
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(PackageRequest $request, $user_id): JsonResponse
    {
        try {
            $validated = $request->validated();
            DB::beginTransaction();

            $output = Output::create([
                'city' => $validated['saida']['cidade'],
                'state' => $validated['saida']['estado'],
                'address' => $validated['saida']['endereco'],
                'latitude' => $validated['saida']['latitude'],
                'longitude' => $validated['saida']['longitude'],
            ]);

            $arrival = Arrival::create([
                'city' => $validated['chegada']['cidade'],
                'state' => $validated['chegada']['estado'],
                'address' => $validated['chegada']['endereco'],
                'latitude' => $validated['chegada']['latitude'],
                'longitude' => $validated['chegada']['longitude'],
            ]);

            $package = Package::create([
                'width' => $validated['pacote']['largura'],
                'metric_width' => $validated['pacote']['metrica_largura'],
                'height' => $validated['pacote']['altura'],
                'metric_height' => $validated['pacote']['metrica_altura'],
                'weight' => $validated['pacote']['peso'],
                'metric_weight' => $validated['pacote']['metrica_peso'],
                'fragility' => $validated['pacote']['fragilidade'],
                'description' => $validated['pacote']['descricao'],
            ]);

            Travel::create([
                'user_id' => $user_id,
                'arrival_id' => $arrival->id_arrival,
                'output_id' => $output->id_output,
                'package_id' => $package->id_package,
                'sent' => 0
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Viagem cadastrada com sucesso buscando motoristas.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTravel($travel_id)
    {
        try {
            $travel = Travel::find($travel_id);

            if ($travel && $travel->sent == 0) {
                $travel->arrival()->delete();
                $travel->output()->delete();
                $travel->package()->delete();

                $travel->delete();

                return response()->json(['message' => 'Entrega apagada com sucesso!']);
            } else {
                return response()->json(['message' => 'Entrega não encontrada!']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
