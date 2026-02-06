<?php

namespace App\Http\Controllers;

use App\Models\PujaPagi;
use Illuminate\Http\JsonResponse;

class PujaPagiApiController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = PujaPagi::aktif()
            ->urut()
            ->get()
            ->map(function ($section) {
                return [
                    'title' => $section->judul,
                    'duration' => $section->durasi ?? '0:00',
                    'description' => $section->deskripsi ?? '',
                    'audioUrl' => $section->audio_path
                        ? url('storage/' . $section->audio_path)
                        : '#',
                    'paliText' => $section->teks_pali ?? '',
                    'translation' => $section->terjemahan ?? '',
                ];
            })
            ->values();

        return response()->json($sections);
    }

    public function show(int $urutan): JsonResponse
    {
        $section = PujaPagi::where('urutan', $urutan)->aktif()->first();

        if (!$section) {
            return response()->json(['error' => 'Section not found'], 404);
        }

        return response()->json([
            'title' => $section->judul,
            'duration' => $section->durasi ?? '0:00',
            'description' => $section->deskripsi ?? '',
            'audioUrl' => $section->audio_path
                ? url('storage/' . $section->audio_path)
                : '#',
            'paliText' => $section->teks_pali ?? '',
            'translation' => $section->terjemahan ?? '',
        ]);
    }
}
