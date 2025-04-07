<?php

namespace App\Policies;

use App\Models\RequestJudul;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization; // Import jika belum ada (biasanya otomatis)
use Illuminate\Auth\Access\Response;

class RequestJudulPolicy
{
    use HandlesAuthorization; // Tambahkan ini jika belum ada

    /**
     * Pre-authorization check for administrators.
     * Admin bisa melakukan apa saja. Method ini dijalankan sebelum method lain.
     * Jika method ini return true/false, method lain tidak akan dijalankan.
     * Jika return null, pengecekan dilanjutkan ke method spesifik (view, create, dll).
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true; // Admin boleh melakukan semuanya
        }
        return null; // Lanjutkan ke pemeriksaan spesifik jika bukan admin
    }

    /**
     * Determine whether the user can view the list of RequestJudul.
     * Semua role yang relevan (mahasiswa, dosen, admin) boleh melihat halaman index.
     * Filtering data (siapa lihat apa) dilakukan di Controller.
     */
    public function viewAny(User $user): bool
    {
        // Asumsinya semua role (mahasiswa, dosen, admin) bisa mengakses halaman daftar
        return in_array($user->role, ['mahasiswa', 'dosen', 'admin']);
    }

    /**
     * Determine whether the user can view a specific RequestJudul model.
     */
    public function view(User $user, RequestJudul $requestJudul): bool
    {
        // Mahasiswa bisa lihat jika itu miliknya
        if ($user->role === 'mahasiswa' && $user->id === $requestJudul->mahasiswa_id) {
            return true;
        }
        // Dosen bisa lihat jika itu ditujukan padanya
        if ($user->role === 'dosen' && $user->id === $requestJudul->dosen_id) {
            return true;
        }
        // Admin sudah ditangani oleh method `before`

        return false; // Default to deny if none of the above matches (selain admin)
    }

    /**
     * Determine whether the user can create RequestJudul models.
     */
    public function create(User $user): bool
    {
        // Hanya mahasiswa yang boleh membuat request judul baru
        return $user->role === 'mahasiswa';
    }

    /**
     * Determine whether the user can update the RequestJudul model.
     */
    public function update(User $user, RequestJudul $requestJudul): bool
    {
        // Hanya mahasiswa yang membuat request yang boleh mengupdatenya
        // (Asumsi: Dosen/Admin tidak mengedit, hanya approve/reject atau hapus)
        // Admin sudah ditangani oleh method `before`
        return $user->role === 'mahasiswa' && $user->id === $requestJudul->mahasiswa_id;
        // Anda bisa tambahkan kondisi status jika perlu, misal:
        // && $requestJudul->status === 'pending'
    }

    /**
     * Determine whether the user can delete the RequestJudul model.
     */
    public function delete(User $user, RequestJudul $requestJudul): bool
    {
        // Hanya mahasiswa yang membuat request yang boleh menghapusnya
        // Admin sudah ditangani oleh method `before`
        return $user->role === 'mahasiswa' && $user->id === $requestJudul->mahasiswa_id;
         // Anda bisa tambahkan kondisi status jika perlu
    }

    /**
     * Determine whether the user can restore the model. (Requires SoftDeletes trait on RequestJudul Model)
     */
    public function restore(User $user, RequestJudul $requestJudul): bool
    {
        // Biasanya hanya admin yang bisa restore
        // Admin sudah ditangani oleh method `before`, jadi di sini bisa false
        return false; // Atau sesuaikan jika ada role lain yang boleh restore
    }

    /**
     * Determine whether the user can permanently delete the model. (Requires SoftDeletes trait on RequestJudul Model)
     */
    public function forceDelete(User $user, RequestJudul $requestJudul): bool
    {
        // Biasanya hanya admin yang bisa force delete
        // Admin sudah ditangani oleh method `before`, jadi di sini bisa false
        return false; // Atau sesuaikan jika ada role lain yang boleh force delete
    }

     // --- Tambahan jika perlu untuk Approve/Reject oleh Dosen ---
     /*
     public function approve(User $user, RequestJudul $requestJudul): bool
     {
         // Hanya dosen yang dituju yang boleh approve
         // Mungkin juga cek status apakah masih pending
         return $user->role === 'dosen' && $user->id === $requestJudul->dosen_id;
              // && $requestJudul->status === 'pending';
     }

     public function reject(User $user, RequestJudul $requestJudul): bool
     {
         // Hanya dosen yang dituju yang boleh reject
         // Mungkin juga cek status apakah masih pending
         return $user->role === 'dosen' && $user->id === $requestJudul->dosen_id;
              // && $requestJudul->status === 'pending';
     }
     */
}
