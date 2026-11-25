<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SellerCourtController extends Controller
{
    // MENGHAPUS CACHE DAFTAR LAPANGAN
    private function clearCourtCache()
    {
        // Menghapus cache daftar lapangan dan daftar kota.
        // Cache::flush digunakan karena setiap kombinasi
        // search, city, price, dan sort memiliki cache key berbeda.
        Cache::flush();
    }

    public function index()
    {
        $courts = Court::where('seller_id', auth()->id())
            ->latest()
            ->get();

        $trashedCourts = Court::onlyTrashed()
            ->where('seller_id', auth()->id())
            ->orderByDesc('deleted_at')
            ->get();

        return view('seller.courts.index', compact(
            'courts',
            'trashedCourts'
        ));
    }

    public function create()
    {
        return view('seller.courts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'venue_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'address' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload foto lapangan
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('courts', 'public');
        }

        $validated['seller_id'] = auth()->id();
        $validated['status'] = 'active';

        Court::create($validated);

        // MEMPERBARUI CACHE
        $this->clearCourtCache();

        return redirect()
            ->route('seller.courts.index')
            ->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $court = Court::where('seller_id', auth()->id())
            ->findOrFail($id);

        return view('seller.courts.edit', compact('court'));
    }

    public function update(Request $request, $id)
    {
        $court = Court::where('seller_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'venue_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'address' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Jika seller mengganti foto
        if ($request->hasFile('image')) {

            $oldImage = $court->image;

            $validated['image'] = $request->file('image')
                ->store('courts', 'public');

            $court->update($validated);

            // Menghapus foto lama
            if ($oldImage && str_starts_with($oldImage, 'courts/')) {
                Storage::disk('public')->delete($oldImage);
            }

        } else {

            unset($validated['image']);

            $court->update($validated);
        }

        // MEMPERBARUI CACHE
        $this->clearCourtCache();

        return redirect()
            ->route('seller.courts.index')
            ->with('success', 'Lapangan berhasil diperbarui!');
    }

    // SOFT DELETE
    public function destroy($id)
    {
        $court = Court::where('seller_id', auth()->id())
            ->findOrFail($id);

        $court->delete();

        // MEMPERBARUI CACHE
        $this->clearCourtCache();

        return redirect()
            ->route('seller.courts.index')
            ->with('success', 'Lapangan berhasil dipindahkan ke Trash!');
    }

    // RESTORE COURT
    public function restore($id)
    {
        $court = Court::onlyTrashed()
            ->where('seller_id', auth()->id())
            ->findOrFail($id);

        $court->restore();

        // MEMPERBARUI CACHE
        $this->clearCourtCache();

        return redirect()
            ->route('seller.courts.index')
            ->with('success', 'Lapangan berhasil dikembalikan!');
    }

    // PERMANENT DELETE
    public function forceDelete($id)
    {
        return DB::transaction(function () use ($id) {

            $court = Court::onlyTrashed()
                ->where('seller_id', auth()->id())
                ->lockForUpdate()
                ->findOrFail($id);

            // Melindungi riwayat booking dan pembayaran
            if ($court->bookings()->exists()) {

                return redirect()
                    ->route('seller.courts.index')
                    ->with(
                        'error',
                        'Lapangan tidak dapat dihapus permanen karena memiliki riwayat booking.'
                    );
            }

            $image = $court->image;

            // Menghapus data secara permanen
            $court->forceDelete();

            // Menghapus foto setelah transaksi berhasil
            if ($image && str_starts_with($image, 'courts/')) {

                DB::afterCommit(function () use ($image) {
                    Storage::disk('public')->delete($image);
                });

            }

            // HAPUS CACHE SETELAH TRANSAKSI BERHASIL
            DB::afterCommit(function () {
                $this->clearCourtCache();
            });

            return redirect()
                ->route('seller.courts.index')
                ->with('success', 'Lapangan berhasil dihapus secara permanen!');

        });
    }
}
