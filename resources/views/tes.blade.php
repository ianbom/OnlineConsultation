<x-admin.app>

<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        font-size: 20px;
    }
    .icon-filled { font-variation-settings: 'FILL' 1; }
</style>

@php
    $isAdmin = auth()->user()?->role === 'admin';
    $isCounselor = auth()->user()?->role === 'counselor';
    $statusConfig = match($booking->status) {
        'pending_payment' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200', 'label' => 'Menunggu Pembayaran', 'icon' => 'hourglass_empty'],
        'dp_paid' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => 'DP Dibayar', 'icon' => 'payments'],
        'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'label' => 'Dibayar', 'icon' => 'check_circle'],
        'completed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Selesai', 'icon' => 'task_alt'],
        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'label' => 'Dibatalkan', 'icon' => 'cancel'],
        'rescheduled' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200', 'label' => 'Dijadwal Ulang', 'icon' => 'event_repeat'],
        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'label' => ucfirst($booking->status), 'icon' => 'info'],
    };
    $paymentConfig = $booking->payment
        ? match($booking->payment->status) {
            'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Success'],
            'partial' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Partial / DP'],
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'],
            'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Failed'],
            'refund', 'refunded' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => ucfirst($booking->payment->status)],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($booking->payment->status)],
        }
        : null;
@endphp

{{-- ===== BREADCRUMBS ===== --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a class="hover:text-[#7b1e2d]" href="{{ route('admin.dashboard') }}">Home</a>
    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    <a class="hover:text-[#7b1e2d]" href="{{ route('admin.booking.index') }}">Booking</a>
    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    <span class="text-gray-800 font-medium">#{{ $booking->id }}</span>
</div>

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        {{-- Left: Title + Badges --}}
        <div>
            <div class="flex items-center gap-3 mb-2 flex-wrap">
                <h1 class="text-2xl font-bold text-gray-900">Booking #{{ $booking->id }}</h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['border'] }}">
                    <span class="material-symbols-outlined text-[14px] icon-filled">{{ $statusConfig['icon'] }}</span>
                    {{ $statusConfig['label'] }}
                </span>

                @if($booking->reschedule_status !== 'none')
                    @php
                        $rescheduleConfig = match($booking->reschedule_status) {
                            'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200', 'label' => 'Reschedule Pending'],
                            'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'label' => 'Reschedule Disetujui'],
                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'label' => 'Reschedule Ditolak'],
                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'label' => ucfirst($booking->reschedule_status)],
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $rescheduleConfig['bg'] }} {{ $rescheduleConfig['text'] }} border {{ $rescheduleConfig['border'] }}">
                        {{ $rescheduleConfig['label'] }}
                    </span>
                @endif

                @if($booking->refund_status !== 'none')
                    @php
                        $refundConfig = match($booking->refund_status) {
                            'requested' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'border' => 'border-purple-200', 'label' => 'Refund Diminta'],
                            'processed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Refund Diproses'],
                            'done' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'label' => 'Refund Selesai'],
                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'label' => ucfirst($booking->refund_status)],
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $refundConfig['bg'] }} {{ $refundConfig['text'] }} border {{ $refundConfig['border'] }}">
                        {{ $refundConfig['label'] }}
                    </span>
                @endif

                @if($booking->is_expired)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                        <span class="material-symbols-outlined text-[14px] icon-filled">timer_off</span> Expired
                    </span>
                @endif

                @if($booking->link_status)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $booking->link_status === 'sent' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                        <span class="material-symbols-outlined text-[14px] icon-filled">link</span>
                        Link {{ ucfirst($booking->link_status) }}
                    </span>
                @endif
            </div>
            <p class="text-sm text-gray-500">Dibuat {{ $booking->created_at->format('d M Y, H:i') }} WIB</p>
        </div>

        {{-- Right: Action Buttons --}}
        <div class="flex items-center gap-3 flex-wrap">
            @if($booking->payment && $booking->payment->payment_url)
                <a href="{{ $booking->payment->payment_url }}" target="_blank" class="inline-flex items-center gap-2 h-9 px-4 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span> Payment Link
                </a>
            @endif
            @if($isAdmin && $booking->consultation_type === 'offline' && $booking->payment_scheme === 'dp' && $booking->status === 'dp_paid')
                <form method="POST" action="{{ route('admin.booking.mark-settled', $booking->id) }}">
                    @csrf @method('PUT')
                    <button type="submit" onclick="return confirm('Tandai booking ini sebagai lunas?')" class="inline-flex items-center gap-2 h-9 px-4 rounded-lg bg-amber-500 text-white text-sm font-medium hover:bg-amber-600 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">payments</span> Tandai Lunas
                    </button>
                </form>
            @endif
            @if($isCounselor && $booking->status == 'paid')
                <form id="completeBookingForm" method="POST" action="{{ route('counselor.booking.completeBooking', $booking->id) }}">
                    @csrf @method('PUT')
                    <button type="button" onclick="confirmCompleteBooking()" class="inline-flex items-center gap-2 h-9 px-4 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span> Tandai Selesai
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Quick Stats Row --}}
    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-x-8 gap-y-2 text-sm">
        <div class="flex items-center gap-2 text-gray-600">
            <span class="material-symbols-outlined text-[#7e1b2b] text-[18px]">calendar_today</span>
            <span>{{ \Carbon\Carbon::parse($booking->schedule->date)->translatedFormat('d M Y') }}</span>
        </div>
        <div class="flex items-center gap-2 text-gray-600">
            <span class="material-symbols-outlined text-[#7e1b2b] text-[18px]">schedule</span>
            <span>{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }} WIB</span>
        </div>
        <div class="flex items-center gap-2 text-gray-600">
            <span class="material-symbols-outlined text-[#7e1b2b] text-[18px]">{{ $booking->consultation_type === 'online' ? 'videocam' : 'location_on' }}</span>
            <span>{{ ucfirst($booking->consultation_type) }} · {{ $booking->duration_hours }} jam · {{ $booking->payment_scheme === 'dp' ? 'DP 50%' : 'Lunas' }}</span>
        </div>
        <div class="ml-auto flex items-center gap-1 text-[#7e1b2b] font-bold text-base">
            Rp {{ number_format($booking->price, 0, ',', '.') }}
        </div>

        @if($booking->payment_scheme === 'dp')
        <div class="bg-amber-50 rounded-xl border border-amber-200 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-amber-600 text-[18px]">payments</span>
                <h2 class="text-xs uppercase tracking-wider text-amber-600 font-bold">Informasi DP Offline</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs text-amber-600/70 mb-1">DP Dibayar</p>
                    <p class="font-semibold text-amber-900">Rp {{ number_format($booking->down_payment_amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-amber-600/70 mb-1">Sisa Pelunasan</p>
                    <p class="font-semibold text-amber-900">Rp {{ number_format($booking->remaining_amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-amber-600/70 mb-1">Status Pelunasan</p>
                    <p class="font-semibold text-amber-900">
                        {{ $booking->remaining_amount > 0 ? 'Belum Lunas' : 'Sudah Lunas' }}
                    </p>
                </div>
            </div>
            @if($booking->settled_at)
                <div class="mt-4 pt-4 border-t border-amber-200 text-sm text-amber-900">
                    Dilunasi pada {{ $booking->settled_at->format('d M Y, H:i') }}
                    @if($booking->settledByAdmin)
                        oleh {{ $booking->settledByAdmin->name }}
                    @endif
                </div>
            @elseif($booking->status === 'dp_paid')
                <p class="mt-4 text-sm text-amber-900/80">
                    Booking tetap aktif, tetapi sesi offline belum bisa dijalankan sampai admin menandai pelunasan.
                </p>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- ===== MAIN GRID ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ==================== LEFT COLUMN (2/3) ==================== --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- CLIENT + COUNSELOR --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Client Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold">Klien</h2>
                    <span class="material-symbols-outlined text-gray-300 text-[18px]">person</span>
                </div>
                <div class="flex items-center gap-3 mb-4">
                    @if($booking->client->profile_pic)
                        <img src="{{ asset('storage/' . $booking->client->profile_pic) }}" alt="{{ $booking->client->name }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100"/>
                    @else
                        <div class="w-12 h-12 rounded-full bg-[#7e1b2b] flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($booking->client->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-900 truncate">{{ $booking->client->name }}</h3>
                        <p class="text-xs text-gray-400">ID: #{{ $booking->client->id }}</p>
                    </div>
                </div>
                <div class="space-y-2 pt-3 border-t border-gray-100 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">email</span>
                        <span class="truncate">{{ $booking->client->email }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">phone</span>
                        <span>{{ $booking->client->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">badge</span>
                        <span>{{ ucfirst($booking->client->role) }}</span>
                    </div>
                    <div class="flex items-center gap-2 {{ $booking->client->email_verified_at ? 'text-green-600' : 'text-orange-500' }}">
                        <span class="material-symbols-outlined text-[16px] {{ $booking->client->email_verified_at ? 'icon-filled' : '' }}">{{ $booking->client->email_verified_at ? 'verified' : 'warning' }}</span>
                        <span class="text-xs font-medium">{{ $booking->client->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}</span>
                    </div>
                </div>
            </div>

            {{-- Counselor Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold">Konselor</h2>
                    <span class="material-symbols-outlined text-gray-300 text-[18px]">psychology</span>
                </div>
                <div class="flex items-center gap-3 mb-4">
                    @if($booking->counselor->user->profile_pic)
                        <img src="{{ asset('storage/' . $booking->counselor->user->profile_pic) }}" alt="{{ $booking->counselor->user->name }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100"/>
                    @else
                        <div class="w-12 h-12 rounded-full bg-[#7e1b2b] flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($booking->counselor->user->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-900 truncate">{{ $booking->counselor->user->name }}</h3>
                        <p class="text-xs text-[#7e1b2b] font-medium truncate">{{ $booking->counselor->specialization }}</p>
                    </div>
                </div>
                <div class="space-y-2 pt-3 border-t border-gray-100 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">school</span>
                        <span class="truncate">{{ $booking->counselor->education }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">email</span>
                        <span class="truncate">{{ $booking->counselor->user->email }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">phone</span>
                        <span>{{ $booking->counselor->user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-2 {{ $booking->counselor->status === 'active' ? 'text-green-600' : 'text-red-500' }}">
                        <span class="material-symbols-outlined text-[16px] icon-filled">{{ $booking->counselor->status === 'active' ? 'check_circle' : 'cancel' }}</span>
                        <span class="text-xs font-medium">{{ $booking->counselor->status === 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCHEDULE --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4">Jadwal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Current Schedule --}}
                <div class="rounded-lg bg-gray-50 border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-[#7e1b2b] text-[18px]">event</span>
                        <span class="text-xs font-bold text-gray-500 uppercase">Jadwal Saat Ini</span>
                    </div>
                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->schedule->date)->translatedFormat('l, d M Y') }}</p>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }} WIB</p>
                    @if($booking->secondSchedule)
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-xs font-medium text-gray-400 mb-1">Jadwal Kedua</p>
                            <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->translatedFormat('l, d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->secondSchedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->secondSchedule->end_time)->format('H:i') }} WIB</p>
                        </div>
                    @endif
                </div>

                {{-- Previous Schedule (if rescheduled) --}}
                @if($booking->reschedule_status !== 'none' && $booking->previousSchedule)
                <div class="rounded-lg bg-orange-50 border border-orange-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-orange-600 text-[18px]">edit_calendar</span>
                        <span class="text-xs font-bold text-orange-500 uppercase">Jadwal Sebelumnya</span>
                    </div>
                    <p class="font-semibold text-orange-900">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->translatedFormat('l, d M Y') }}</p>
                    <p class="text-sm text-orange-700">{{ \Carbon\Carbon::parse($booking->previousSchedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->previousSchedule->end_time)->format('H:i') }} WIB</p>
                    @if($booking->previousSecondSchedule)
                        <div class="mt-3 pt-3 border-t border-orange-200">
                            <p class="text-xs font-medium text-orange-400 mb-1">Jadwal Kedua (Sebelumnya)</p>
                            <p class="text-sm font-semibold text-orange-900">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->translatedFormat('l, d M Y') }}</p>
                            <p class="text-xs text-orange-700">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->end_time)->format('H:i') }} WIB</p>
                        </div>
                    @endif
                    @if($booking->reschedule_reason)
                        <div class="mt-3 pt-3 border-t border-orange-200">
                            <p class="text-xs font-medium text-orange-500">Alasan:</p>
                            <p class="text-sm text-orange-800">{{ $booking->reschedule_reason }}</p>
                        </div>
                    @endif
                    @if($booking->reschedule_by)
                        <p class="text-xs text-orange-500 mt-2">Oleh: <strong>{{ ucfirst($booking->reschedule_by) }}</strong></p>
                    @endif
                </div>
                @else
                <div class="rounded-lg bg-gray-50 border border-dashed border-gray-200 p-4 flex items-center justify-center">
                    <p class="text-sm text-gray-400">Tidak ada reschedule</p>
                </div>
                @endif
            </div>
        </div>

        {{-- MEETING LINK + NOTES FORM (paid only) --}}
        @if($booking->status === 'paid')
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4">Input Data Meeting</h2>
            <form method="POST" action="{{ route('counselor.booking.inputLinkandNotes', $booking->id) }}">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Meeting</label>
                        <input type="text" name="meeting_link" value="{{ $booking->meeting_link }}"
                            placeholder="https://zoom.us/j/123456789"
                            class="w-full rounded-lg border-gray-300 text-sm py-2 px-3 focus:ring-[#7e1b2b] focus:border-[#7e1b2b]"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Link</label>
                        <select name="link_status" class="w-full rounded-lg border-gray-300 text-sm py-2 px-3 focus:ring-[#7e1b2b] focus:border-[#7e1b2b]">
                            <option value="pending" {{ $booking->link_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="sent" {{ $booking->link_status === 'sent' ? 'selected' : '' }}>Sent</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Konselor</label>
                    <textarea name="counselor_notes" rows="3" placeholder="Catatan sesi, observasi, langkah selanjutnya..."
                        class="w-full rounded-lg border-gray-300 text-sm p-3 focus:ring-[#7e1b2b] focus:border-[#7e1b2b]">{{ $booking->counselor_notes }}</textarea>
                    <p class="mt-1 text-xs text-gray-400">Catatan hanya terlihat oleh konselor dan admin.</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg text-white bg-[#7e1b2b] hover:bg-[#9e2b3e] transition-colors">
                        <span class="material-symbols-outlined text-[16px]">save</span> Simpan
                    </button>
                </div>
            </form>
        </div>
        @endif

        @if($isCounselor && $booking->status === 'dp_paid')
        <div class="bg-amber-50 rounded-xl border border-amber-200 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-amber-600 text-[18px]">warning</span>
                <h2 class="text-xs uppercase tracking-wider text-amber-600 font-bold">Menunggu Pelunasan</h2>
            </div>
            <p class="text-sm text-amber-900 leading-relaxed">
                Booking offline ini baru membayar DP. Input data meeting dan penyelesaian sesi akan aktif setelah admin mengonfirmasi pelunasan penuh.
            </p>
        </div>
        @endif

     
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4">Catatan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-lg bg-gray-50 border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan Klien</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $booking->notes ?: 'Tidak ada catatan.' }}</p>
                </div>
                <div class="rounded-lg bg-gray-50 border border-gray-100 p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan Konselor</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $booking->counselor_notes ?: 'Tidak ada catatan.' }}</p>
                </div>
            </div>
        </div>
     

        {{-- CANCELLATION --}}
        @if($booking->status === 'cancelled')
        <div class="bg-white rounded-xl border border-red-200 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-red-500 text-[18px]">cancel</span>
                <h2 class="text-xs uppercase tracking-wider text-red-500 font-bold">Informasi Pembatalan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Dibatalkan Oleh</p>
                    <p class="font-semibold text-gray-900">{{ ucfirst($booking->cancelled_by ?? '-') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Waktu</p>
                    <p class="font-semibold text-gray-900">{{ $booking->cancelled_at ? $booking->cancelled_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Alasan</p>
                    <p class="text-gray-700">{{ $booking->cancel_reason ?: 'Tidak ada alasan.' }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- REFUND --}}
        @if($booking->refund_status !== 'none')
        <div class="bg-white rounded-xl border border-blue-200 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-blue-500 text-[18px]">currency_exchange</span>
                <h2 class="text-xs uppercase tracking-wider text-blue-500 font-bold">Informasi Refund</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Status</p>
                    <p class="font-semibold text-gray-900">{{ ucfirst($booking->refund_status) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Diproses Pada</p>
                    <p class="font-semibold text-gray-900">{{ $booking->refund_processed_at ? $booking->refund_processed_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                @if($booking->payment && $booking->payment->refund_amount)
                <div>
                    <p class="text-xs text-gray-400 mb-1">Jumlah</p>
                    <p class="font-semibold text-gray-900">Rp {{ number_format($booking->payment->refund_amount, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>
            @if($booking->payment && $booking->payment->refund_reason)
            <div class="mt-3 pt-3 border-t border-gray-100 text-sm">
                <p class="text-xs text-gray-400 mb-1">Alasan</p>
                <p class="text-gray-700">{{ $booking->payment->refund_reason }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- ORDER / PAYMENT TABS --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm" x-data="{ tab: 'order' }">
            <div class="flex border-b border-gray-200">
                <button @click="tab = 'order'" :class="tab === 'order' ? 'border-[#7e1b2b] text-[#7e1b2b]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="flex-1 py-3 text-sm font-medium border-b-2 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">receipt</span> Detail Pesanan
                </button>
                <button @click="tab = 'payment'" :class="tab === 'payment' ? 'border-[#7e1b2b] text-[#7e1b2b]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="flex-1 py-3 text-sm font-medium border-b-2 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">payments</span> Pembayaran
                </button>
                <button @click="tab = 'refund'" :class="tab === 'refund' ? 'border-[#7e1b2b] text-[#7e1b2b]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="flex-1 py-3 text-sm font-medium border-b-2 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">currency_exchange</span> Refund
                </button>
            </div>
            <div class="p-5">
                {{-- Order Tab --}}
                <div x-show="tab === 'order'">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div><p class="text-xs text-gray-400 mb-0.5">Booking ID</p><p class="font-medium text-gray-900">#{{ $booking->id }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Dibuat</p><p class="font-medium text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Tipe</p><p class="font-medium text-gray-900">{{ ucfirst($booking->consultation_type) }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Durasi</p><p class="font-medium text-gray-900">{{ $booking->duration_hours }} jam</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Status</p><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</span></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Skema Bayar</p><p class="font-medium text-gray-900">{{ $booking->payment_scheme === 'dp' ? 'DP 50%' : 'Lunas' }}</p></div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Meeting Link</p>
                            @if($booking->meeting_link)
                                <a href="{{ $booking->meeting_link }}" target="_blank" class="font-medium text-[#7e1b2b] hover:underline text-xs break-all">{{ $booking->meeting_link }}</a>
                            @else
                                <p class="text-gray-400 text-xs">Belum diatur</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center bg-gray-50 rounded-lg p-3">
                        <span class="text-sm text-gray-500">Total Harga</span>
                        <span class="text-lg font-bold text-[#7e1b2b]">Rp {{ number_format($booking->price, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->payment_scheme === 'dp')
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <div class="rounded-lg bg-amber-50 border border-amber-200 p-3">
                            <p class="text-xs text-amber-600/70 mb-1">DP Dibayar</p>
                            <p class="font-semibold text-amber-900">Rp {{ number_format($booking->down_payment_amount ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-lg bg-amber-50 border border-amber-200 p-3">
                            <p class="text-xs text-amber-600/70 mb-1">Sisa</p>
                            <p class="font-semibold text-amber-900">Rp {{ number_format($booking->remaining_amount ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-lg bg-amber-50 border border-amber-200 p-3">
                            <p class="text-xs text-amber-600/70 mb-1">Pelunasan Admin</p>
                            <p class="font-semibold text-amber-900">{{ $booking->settled_at ? 'Sudah' : 'Belum' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Payment Tab --}}
                <div x-show="tab === 'payment'" style="display: none;">
                    @if($booking->payment)
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div><p class="text-xs text-gray-400 mb-0.5">Order ID</p><p class="font-medium text-gray-900 font-mono text-xs break-all">{{ $booking->payment->order_id }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Status</p><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $paymentConfig['bg'] }} {{ $paymentConfig['text'] }}">{{ $paymentConfig['label'] }}</span></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Metode</p><p class="font-medium text-gray-900">{{ $booking->payment->method ?? $booking->payment->payment_type ?? '-' }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Transaction Status</p><p class="font-medium text-gray-900">{{ $booking->payment->transaction_status ?? '-' }}</p></div>
                        @if($booking->payment->va_number)
                        <div><p class="text-xs text-gray-400 mb-0.5">VA Number</p><p class="font-medium text-gray-900 font-mono">{{ $booking->payment->va_number }}</p></div>
                        @endif
                        @if($booking->payment->midtrans_transaction_id)
                        <div><p class="text-xs text-gray-400 mb-0.5">Midtrans TX ID</p><p class="font-medium text-gray-900 font-mono text-xs break-all">{{ $booking->payment->midtrans_transaction_id }}</p></div>
                        @endif
                        <div><p class="text-xs text-gray-400 mb-0.5">Dibayar</p><p class="font-medium text-gray-900">{{ $booking->payment->paid_at ? \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y, H:i') : '-' }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Settlement</p><p class="font-medium text-gray-900">{{ $booking->payment->settlement_time ? \Carbon\Carbon::parse($booking->payment->settlement_time)->format('d M Y, H:i') : '-' }}</p></div>
                        @if($booking->payment->expiry_time)
                        <div><p class="text-xs text-gray-400 mb-0.5">Expiry</p><p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->payment->expiry_time)->format('d M Y, H:i') }}</p></div>
                        @endif
                        @if($booking->payment->fraud_status)
                        <div><p class="text-xs text-gray-400 mb-0.5">Fraud Status</p><p class="font-medium text-gray-900">{{ $booking->payment->fraud_status }}</p></div>
                        @endif
                        @if($booking->payment->failure_reason)
                        <div class="col-span-2"><p class="text-xs text-gray-400 mb-0.5">Failure Reason</p><p class="font-medium text-red-600">{{ $booking->payment->failure_reason }}</p></div>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center bg-gray-50 rounded-lg p-3">
                        <span class="text-sm text-gray-500">{{ $booking->payment_scheme === 'dp' ? 'Jumlah Dibayar Sekarang' : 'Jumlah' }}</span>
                        <span class="text-lg font-bold text-[#7e1b2b]">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->payment_scheme === 'dp')
                    <div class="mt-3 rounded-lg bg-amber-50 border border-amber-200 p-3 text-sm text-amber-900">
                        Sisa pelunasan: <strong>Rp {{ number_format($booking->remaining_amount ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    @endif
                    @if($booking->payment->payment_url)
                    <div class="mt-3">
                        <a href="{{ $booking->payment->payment_url }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-[#7e1b2b] hover:underline">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span> Buka Payment Link
                        </a>
                    </div>
                    @endif
                    @else
                    <p class="text-sm text-gray-400 py-4 text-center">Belum ada data pembayaran.</p>
                    @endif
                </div>

                {{-- Refund Tab --}}
                <div x-show="tab === 'refund'" style="display: none;">
                    @if($booking->refund_status !== 'none' || ($booking->payment && ($booking->payment->refund_amount || $booking->payment->refund_reason)))
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Status Refund</p>
                            @php
                                $refundBadge = match($booking->refund_status) {
                                    'requested' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
                                    'processed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                    'done' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                    default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $refundBadge['bg'] }} {{ $refundBadge['text'] }}">{{ ucfirst($booking->refund_status) }}</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Diproses Pada</p>
                            <p class="font-medium text-gray-900">{{ $booking->refund_processed_at ? $booking->refund_processed_at->format('d M Y, H:i') : '-' }}</p>
                        </div>
                        @if($booking->payment && $booking->payment->refund_amount)
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Jumlah Refund</p>
                            <p class="font-medium text-gray-900">Rp {{ number_format($booking->payment->refund_amount, 0, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($booking->payment && $booking->payment->refund_time)
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Waktu Refund</p>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->payment->refund_time)->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                    @if($booking->payment && $booking->payment->refund_reason)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400 mb-1">Alasan Refund</p>
                        <p class="text-sm text-gray-700">{{ $booking->payment->refund_reason }}</p>
                    </div>
                    @endif
                    @else
                    <p class="text-sm text-gray-400 py-4 text-center">Tidak ada data refund.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== RIGHT COLUMN (1/3) ==================== --}}
    <div class="space-y-6">

        {{-- INVOICE CARD --}}
        <div class="bg-[#7e1b2b] text-white rounded-xl shadow-md p-5 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-white opacity-5"></div>
            <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-white opacity-5"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-white text-xs font-medium opacity-80">Total Harga</span>
                    <span class="material-symbols-outlined text-white text-[18px] opacity-60">receipt_long</span>
                </div>
                <p class="text-2xl font-bold">Rp {{ number_format($booking->price, 0, ',', '.') }}</p>
                <p class="text-xs opacity-60 mt-1">Booking #{{ $booking->id }}</p>
                @if($booking->payment)
                <p class="text-xs opacity-60">{{ $booking->payment->order_id }}</p>
                @endif
            </div>
        </div>

        {{-- TIMELINE --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-5">Timeline</h2>
            <div class="relative pl-5 border-l-2 border-gray-200 space-y-6">
                {{-- Created --}}
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-[#7e1b2b] border-2 border-white"></span>
                    <p class="text-sm font-semibold text-gray-900 leading-tight">Booking Dibuat</p>
                    <p class="text-xs text-gray-400">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>

                @if($booking->payment && $booking->payment->paid_at)
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-[#7e1b2b] border-2 border-white"></span>
                    <p class="text-sm font-semibold text-gray-900 leading-tight">{{ $booking->payment_scheme === 'dp' ? 'DP Terverifikasi' : 'Pembayaran Terverifikasi' }}</p>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y, H:i') }}</p>
                    <p class="text-xs text-green-600 font-medium">via {{ $booking->payment->method ?? $booking->payment->payment_type ?? '-' }}</p>
                </div>
                @endif

                @if($booking->settled_at)
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-amber-500 border-2 border-white"></span>
                    <p class="text-sm font-semibold text-amber-700 leading-tight">Pelunasan Manual Dikonfirmasi</p>
                    <p class="text-xs text-gray-400">{{ $booking->settled_at->format('d M Y, H:i') }}</p>
                    @if($booking->settledByAdmin)
                    <p class="text-xs text-amber-600 font-medium">oleh {{ $booking->settledByAdmin->name }}</p>
                    @endif
                </div>
                @endif

                @if($booking->reschedule_status !== 'none')
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-orange-500 border-2 border-white"></span>
                    <p class="text-sm font-semibold text-orange-700 leading-tight">Reschedule {{ ucfirst($booking->reschedule_status) }}</p>
                    @if($booking->reschedule_by)
                    <p class="text-xs text-gray-400">Oleh: {{ ucfirst($booking->reschedule_by) }}</p>
                    @endif
                </div>
                @endif

                @if($booking->status === 'completed')
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-blue-500 border-2 border-white"></span>
                    <p class="text-sm font-semibold text-gray-900 leading-tight">Sesi Selesai</p>
                    <p class="text-xs text-gray-400">{{ $booking->updated_at->format('d M Y, H:i') }}</p>
                </div>
                @endif

                @if($booking->status === 'cancelled')
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
                    <p class="text-sm font-semibold text-red-700 leading-tight">Dibatalkan</p>
                    <p class="text-xs text-gray-400">{{ $booking->cancelled_at ? $booking->cancelled_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                @endif

                @if(in_array($booking->status, ['paid', 'pending_payment', 'dp_paid']))
                <div class="relative">
                    <span class="absolute -left-[17px] top-0.5 h-3 w-3 rounded-full bg-white border-2 border-[#7e1b2b] animate-pulse"></span>
                    <p class="text-sm font-semibold text-[#7e1b2b] leading-tight">
                        {{ $booking->status === 'paid' ? 'Menunggu Sesi' : ($booking->status === 'dp_paid' ? 'Menunggu Pelunasan Offline' : 'Menunggu Pembayaran') }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- MEETING LINK --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold">Meeting Link</h2>
                @if($booking->meeting_link)
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-green-100 text-green-700">Aktif</span>
                @else
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">Kosong</span>
                @endif
            </div>
            @if($booking->meeting_link)
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex items-center justify-between gap-2">
                <p class="text-sm text-gray-700 truncate flex-1">{{ $booking->meeting_link }}</p>
                <button onclick="copyToClipboard('{{ $booking->meeting_link }}')" class="text-gray-400 hover:text-[#7e1b2b] transition-colors flex-shrink-0" title="Salin">
                    <span class="material-symbols-outlined text-[18px]">content_copy</span>
                </button>
                <a href="{{ $booking->meeting_link }}" target="_blank" class="text-gray-400 hover:text-[#7e1b2b] transition-colors flex-shrink-0" title="Buka">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                </a>
            </div>
            @else
            <p class="text-sm text-gray-400">Belum tersedia.</p>
            @endif
        </div>

        {{-- RATING --}}
        @if($booking->rating)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold">Rating</h2>
                <span class="text-xs text-gray-400">{{ $booking->rating->created_at->format('d M Y') }}</span>
            </div>
            <div class="flex items-center gap-0.5 mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-xl icon-filled {{ $i <= $booking->rating->rating ? 'text-yellow-400' : 'text-gray-200' }}">star</span>
                @endfor
                <span class="ml-2 text-sm font-bold text-gray-700">{{ $booking->rating->rating }}/5</span>
            </div>
            @if($booking->rating->commentar)
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <p class="text-sm text-gray-600 italic leading-relaxed">"{{ $booking->rating->commentar }}"</p>
                <div class="mt-2 flex items-center gap-2">
                    @if($booking->client->profile_pic)
                        <img src="{{ asset('storage/' . $booking->client->profile_pic) }}" alt="" class="w-5 h-5 rounded-full object-cover"/>
                    @else
                        <div class="w-5 h-5 rounded-full bg-[#7e1b2b] flex items-center justify-center text-white text-[10px] font-bold">
                            {{ strtoupper(substr($booking->client->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-xs text-gray-500">{{ $booking->client->name }}</span>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- RESCHEDULE ACTIONS --}}
        @if($booking->reschedule_status === 'pending')
        <div class="bg-white rounded-xl border border-orange-200 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-orange-500 text-[18px]">event_repeat</span>
                <h2 class="text-xs uppercase tracking-wider text-orange-500 font-bold">Aksi Reschedule</h2>
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Alasan penolakan (opsional)</label>
                <input type="text" id="rejection_reason_input" form="rejectForm" name="rejection_reason"
                    placeholder="Tulis alasan jika menolak..."
                    class="w-full h-9 px-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-[#7e1b2b] focus:border-[#7e1b2b]"/>
            </div>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}" class="flex-1">
                    @csrf @method('PUT')
                    <input type="hidden" name="statusReschedule" value="approved">
                    <button type="submit" class="w-full h-9 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">check</span> Setujui
                    </button>
                </form>
                <form id="rejectForm" method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}" class="flex-1">
                    @csrf @method('PUT')
                    <input type="hidden" name="statusReschedule" value="rejected">
                    <button type="submit" class="w-full h-9 rounded-lg bg-white text-red-600 text-sm font-medium border border-red-200 hover:bg-red-50 transition-colors flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">close</span> Tolak
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const t = document.createElement('div');
        t.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm flex items-center gap-2';
        t.innerHTML = '<span class="material-symbols-outlined text-green-400 text-[18px]">check_circle</span> Disalin!';
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 2000);
    });
}

function confirmCompleteBooking() {
    if (confirm("Tandai sesi ini sebagai selesai? Tindakan ini tidak dapat dibatalkan.")) {
        document.getElementById('completeBookingForm').submit();
    }
}
</script>

</x-admin.app>
