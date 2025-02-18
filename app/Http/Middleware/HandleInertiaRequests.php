<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
        ]);
    }
}

//Berikut adalah penjelasan singkat dari kode tersebut:
//[-] public function share(Request $request): array: Ini adalah deklarasi fungsi share(). Fungsi ini menerima parameter $request yang merupakan permintaan HTTP saat ini dan mengembalikan sebuah array.
//[-] return array_merge(parent::share($request), [...]: Fungsi ini menggabungkan data yang akan dibagikan dengan tampilan. parent::share($request) memanggil implementasi share() dari kelas induk (parent class), dan kemudian hasilnya digabungkan dengan data tambahan yang akan ditambahkan dalam array asosiatif.
//[-] 'auth' => [...]: Bagian ini menambahkan data yang terkait dengan otentikasi pengguna. Ini mencakup informasi pengguna saat ini yang diambil dari permintaan HTTP.
//[-] 'ziggy' => [...]: Bagian ini menambahkan data yang terkait dengan routing JavaScript yang dihasilkan oleh Ziggy, sebuah pustaka yang membantu dalam menangani routing pada aplikasi web JavaScript. Ini termasuk URL saat ini yang diambil dari permintaan HTTP.
//[-] 'flash' => [...]: Bagian ini menambahkan data yang terkait dengan pesan flash. Pesan flash biasanya digunakan untuk menampilkan pesan sukses atau pesan kesalahan kepada pengguna setelah tindakan tertentu. Data ini diambil dari sesi (session) dan termasuk pesan sukses dan pesan kesalahan yang mungkin ada.