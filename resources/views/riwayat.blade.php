<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-file-medical text-emerald-400 text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Rekam Medis Pemeriksaan Mata</h1>
                    <p class="text-slate-400 text-xs mt-0.5">EyeExpert System · Computer Vision & Expert System Pipeline</p>
                </div>
            </div>
            <div class="mt-4 h-px bg-gradient-to-r from-emerald-500/40 via-slate-700 to-transparent"></div>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('riwayat.destroy_bulk') }}" method="POST" id="bulk-delete-form">
            @csrf
            @method('DELETE')

            {{-- Toolbar --}}
            <div class="bg-slate-800/60 backdrop-blur-sm rounded-2xl border border-slate-700/60 shadow-xl mb-4 px-5 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 text-emerald-400 px-3 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        Sistem Aktif
                    </span>
                    <span class="text-slate-500 text-xs font-medium">Total {{ $diagnoses->total() }} rekam medis</span>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" id="btn-delete-selected"
                        class="hidden items-center gap-2 bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 font-bold px-4 py-2 rounded-xl text-xs transition-all active:scale-95">
                        <i class="fa-regular fa-trash-can"></i> Hapus (<span id="selected-count">0</span>)
                    </button>
                    <a href="{{ route('diagnosa.index') }}"
                        class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition-all shadow-lg active:scale-95 w-full sm:w-auto">
                        <i class="fa-solid fa-plus"></i> Pemeriksaan Baru
                    </a>
                </div>
            </div>

            {{-- ===================== MOBILE VIEW ===================== --}}
            <div class="block lg:hidden space-y-3">
                @if($diagnoses->count() > 0)
                <div class="flex items-center gap-2 px-1 pb-1">
                    <input type="checkbox" id="check-all-mobile" class="rounded border-slate-600 bg-slate-800 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                    <label for="check-all-mobile" class="text-slate-400 text-xs cursor-pointer">Pilih semua</label>
                </div>
                @endif

                @forelse ($diagnoses as $item)
                @php
                    $source = $item->source ?? 'ai';
                    $result = strtolower($item->result);

                    if ($source === 'refraksi') {
                        $badge = 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20';
                        $icon  = 'fa-glasses';
                    } elseif ($source === 'butawarna') {
                        $badge = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                        $icon  = 'fa-palette';
                    } elseif (str_contains($result, 'gagal') || str_contains($result, 'bukan') || str_contains($result, 'berkacamata')) {
                        $badge = 'bg-rose-500/10 text-rose-400 border-rose-500/20'; $icon = 'fa-triangle-exclamation';
                    } elseif (str_contains($result, 'normal') || str_contains($result, 'sehat')) {
                        $badge = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'; $icon = 'fa-circle-check';
                    } elseif (str_contains($result, 'katarak')) {
                        $badge = 'bg-blue-500/10 text-blue-400 border-blue-500/20'; $icon = 'fa-eye';
                    } elseif (str_contains($result, 'uveitis') || str_contains($result, 'peradangan')) {
                        $badge = 'bg-orange-500/10 text-orange-400 border-orange-500/20'; $icon = 'fa-fire';
                    } elseif (str_contains($result, 'hordeolum') || str_contains($result, 'bintitan')) {
                        $badge = 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'; $icon = 'fa-circle-dot';
                    } else {
                        $badge = 'bg-amber-500/10 text-amber-400 border-amber-500/20'; $icon = 'fa-eye-dropper';
                    }

                    $cf = $item->confidence;
                    $cfColor = $cf >= 80 ? 'bg-emerald-500' : ($cf >= 50 ? 'bg-yellow-500' : 'bg-rose-500');

                    $checkboxValue = match($source) {
                        'ai'        => 'ai-' . $item->id,
                        'refraksi'  => 'ref-' . $item->id,
                        'butawarna' => 'cb-' . $item->id,
                        default     => 'ai-' . $item->id,
                    };

                    $kodePrefix = match($source) {
                        'ai'        => 'EXM',
                        'refraksi'  => 'REF',
                        'butawarna' => 'CB',
                        default     => 'EXM',
                    };
                @endphp

                <div class="bg-slate-800/60 backdrop-blur-sm rounded-2xl border border-slate-700/60 shadow-lg overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-700/50">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="ids[]" value="{{ $checkboxValue }}" class="check-item check-item-mobile rounded border-slate-600 bg-slate-800 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                            <span class="font-mono text-xs font-black text-white tracking-widest">#{{ $kodePrefix }}-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <span class="text-slate-500 text-[10px]">
                            {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div class="px-4 py-3 space-y-3">
                        <div class="flex items-center gap-3">
                            <p class="text-white font-semibold text-sm capitalize">
    {{ $item->user->name ?? 'Pasien Anonim' }}
</p>
                            <div>
                                <p class="text-white font-semibold text-sm capitalize">{{ $item->user->name ?? 'Pasien Tidak Diketahui' }}</p>
                                <p class="text-slate-500 text-[10px]">{{ $item->user->email ?? '-' }} · {{ $item->age }} @if($item->age !== '-') Tahun @endif</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <span class="inline-flex items-center gap-1.5 {{ $badge }} px-3 py-1.5 rounded-full text-[11px] font-bold border">
                                <i class="fa-solid {{ $icon }} text-[10px]"></i>
                                {{ $item->result }}
                            </span>
                            <div class="flex items-center gap-2 shrink-0">
                                <div class="w-16 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="{{ $cfColor }} h-full rounded-full" style="width:{{ $cf }}%"></div>
                                </div>
                                <span class="font-mono text-xs font-black text-white">{{ $cf }}%</span>
                            </div>
                        </div>
                    </div>

                    @if($source === 'ai')
                    <div class="grid grid-cols-2 border-t border-slate-700/50">
                        <a href="{{ route('riwayat.show', $item->id) }}" class="flex items-center justify-center gap-2 py-3 text-slate-300 hover:text-blue-400 hover:bg-blue-500/5 text-xs font-bold transition-all border-r border-slate-700/50 active:scale-95">
                            <i class="fa-solid fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('riwayat.pdf', $item->id) }}" class="flex items-center justify-center gap-2 py-3 text-slate-300 hover:text-emerald-400 hover:bg-emerald-500/5 text-xs font-bold transition-all active:scale-95">
                            <i class="fa-solid fa-print"></i> Cetak PDF
                        </a>
                    </div>
                    @elseif($source === 'refraksi')
                    <div class="grid grid-cols-1 border-t border-slate-700/50">
                        <a href="{{ route('riwayat.refraksi.pdf', $item->id) }}" class="flex items-center justify-center gap-2 py-3 text-slate-300 hover:text-cyan-400 hover:bg-cyan-500/5 text-xs font-bold transition-all active:scale-95">
                            <i class="fa-solid fa-print"></i> Cetak Hasil Tes Refraksi
                        </a>
                    </div>
                    @else
                    <div class="grid grid-cols-1 border-t border-slate-700/50">
                        <a href="{{ route('riwayat.butawarna.pdf', $item->id) }}" class="flex items-center justify-center gap-2 py-3 text-slate-300 hover:text-purple-400 hover:bg-purple-500/5 text-xs font-bold transition-all active:scale-95">
                            <i class="fa-solid fa-print"></i> Cetak Hasil Skrining Warna
                        </a>
                    </div>
                    @endif
                </div>
                @empty
                <div class="bg-slate-800/60 rounded-2xl border border-slate-700/60 p-12 text-center">
                    <div class="w-14 h-14 bg-slate-700/50 rounded-2xl flex items-center justify-center border border-slate-600 mx-auto mb-4">
                        <i class="fa-solid fa-folder-open text-xl text-slate-500"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">Belum Ada Rekam Medis</h3>
                    <a href="{{ route('diagnosa.index') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-xl text-xs mt-4">
                        <i class="fa-solid fa-stethoscope"></i> Mulai Pemeriksaan
                    </a>
                </div>
                @endforelse
            </div>

            {{-- ===================== DESKTOP VIEW ===================== --}}
            <div class="hidden lg:block bg-slate-800/60 backdrop-blur-sm rounded-3xl border border-slate-700/60 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-950/60 text-emerald-400 text-[11px] uppercase tracking-widest border-b border-slate-700/60">
                                <th class="px-6 py-4 font-bold w-12 text-center">
                                    <input type="checkbox" id="check-all-desktop" class="rounded border-slate-600 bg-slate-800/50 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                                </th>
                                <th class="px-4 py-4 font-bold">No. Rekam Medis</th>
                                <th class="px-6 py-4 font-bold">Nama Pasien</th>
                                <th class="px-6 py-4 font-bold">Usia</th>
                                <th class="px-6 py-4 font-bold">Tanggal Pemeriksaan</th>
                                <th class="px-6 py-4 font-bold">Hasil Diagnosa</th>
                                <th class="px-6 py-4 font-bold text-center">Tingkat Keyakinan</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/40">
                            @forelse ($diagnoses as $item)
                            @php
                                $source = $item->source ?? 'ai';
                                $result = strtolower($item->result);

                                if ($source === 'refraksi') {
                                    $badge = 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20';
                                    $icon  = 'fa-glasses';
                                } elseif ($source === 'butawarna') {
                                    $badge = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                                    $icon  = 'fa-palette';
                                } elseif (str_contains($result, 'gagal') || str_contains($result, 'bukan') || str_contains($result, 'berkacamata')) {
                                    $badge = 'bg-rose-500/10 text-rose-400 border-rose-500/20'; $icon = 'fa-triangle-exclamation';
                                } elseif (str_contains($result, 'normal') || str_contains($result, 'sehat')) {
                                    $badge = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'; $icon = 'fa-circle-check';
                                } elseif (str_contains($result, 'katarak')) {
                                    $badge = 'bg-blue-500/10 text-blue-400 border-blue-500/20'; $icon = 'fa-eye';
                                } elseif (str_contains($result, 'uveitis') || str_contains($result, 'peradangan')) {
                                    $badge = 'bg-orange-500/10 text-orange-400 border-orange-500/20'; $icon = 'fa-fire';
                                } elseif (str_contains($result, 'hordeolum') || str_contains($result, 'bintitan')) {
                                    $badge = 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'; $icon = 'fa-circle-dot';
                                } else {
                                    $badge = 'bg-amber-500/10 text-amber-400 border-amber-500/20'; $icon = 'fa-eye-dropper';
                                }

                                $cf = $item->confidence;
                                $cfColor = $cf >= 80 ? 'bg-emerald-500' : ($cf >= 50 ? 'bg-yellow-500' : 'bg-rose-500');

                                $checkboxValue = match($source) {
                                    'ai'        => 'ai-' . $item->id,
                                    'refraksi'  => 'ref-' . $item->id,
                                    'butawarna' => 'cb-' . $item->id,
                                    default     => 'ai-' . $item->id,
                                };

                                $kodePrefix = match($source) {
                                    'ai'        => 'EXM',
                                    'refraksi'  => 'REF',
                                    'butawarna' => 'CB',
                                    default     => 'EXM',
                                };
                            @endphp
                            <tr class="hover:bg-slate-700/30 transition-colors duration-150 group">
                                <td class="px-6 py-5 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $checkboxValue }}" class="check-item check-item-desktop rounded border-slate-600 bg-slate-800/50 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                                </td>
                                <td class="px-4 py-5">
                                    <span class="font-mono text-xs font-black text-white tracking-widest">#{{ $kodePrefix }}-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black text-xs shrink-0">
                                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold text-sm capitalize">{{ $item->user->name ?? 'Pasien Tidak Diketahui' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
    @if(isset($item->patient_age) && $item->patient_age !== '-')
        <span class="text-white font-bold">{{ $item->patient_age }}</span> 
        <span class="text-slate-500 text-[10px]">Tahun</span>
    @else
        <span class="text-slate-500 text-xs">-</span>
    @endif
</td>
                                <td class="px-6 py-5 text-slate-200 font-semibold text-xs">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 {{ $badge }} px-3 py-1.5 rounded-full text-[11px] font-bold border whitespace-nowrap">
                                        <i class="fa-solid {{ $icon }} text-[10px]"></i> {{ $item->result }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <span class="font-mono text-sm font-black text-white">{{ $cf }}%</span>
                                        <div class="w-20 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                            <div class="{{ $cfColor }} h-full rounded-full" style="width:{{ $cf }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($source === 'ai')
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('riwayat.show', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-slate-700 hover:bg-blue-600 text-slate-300 hover:text-white rounded-lg transition-all border border-slate-600">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('riwayat.pdf', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-slate-700 hover:bg-emerald-600 text-slate-300 hover:text-white rounded-lg transition-all border border-slate-600">
                                            <i class="fa-solid fa-print text-xs"></i>
                                        </a>
                                    </div>
                                    @elseif($source === 'refraksi')
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('riwayat.refraksi.pdf', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-slate-700 hover:bg-cyan-600 text-slate-300 hover:text-white rounded-lg transition-all border border-slate-600">
                                            <i class="fa-solid fa-print text-xs"></i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('riwayat.butawarna.pdf', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-slate-700 hover:bg-purple-600 text-slate-300 hover:text-white rounded-lg transition-all border border-slate-600">
                                            <i class="fa-solid fa-print text-xs"></i>
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center">
                                    <h3 class="text-base font-bold text-white">Belum Ada Rekam Medis</h3>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        @if($diagnoses->hasPages())
        <div class="mt-5 flex justify-center">{{ $diagnoses->links() }}</div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnDelete  = document.getElementById('btn-delete-selected');
    const countSpan  = document.getElementById('selected-count');
    const formDelete = document.getElementById('bulk-delete-form');
    const checkAllDesktop = document.getElementById('check-all-desktop');
    const checkAllMobile  = document.getElementById('check-all-mobile');

    function updateDeleteButton() {
        const n = document.querySelectorAll('.check-item:checked').length;
        countSpan.textContent = n;
        btnDelete.classList.toggle('hidden', n === 0);
        btnDelete.classList.toggle('inline-flex', n > 0);
    }

    function bindSelectAll(masterCheckbox, itemClass) {
        if (!masterCheckbox) return;
        masterCheckbox.addEventListener('change', function () {
            document.querySelectorAll('.' + itemClass).forEach(i => i.checked = this.checked);
            updateDeleteButton();
        });
    }

    bindSelectAll(checkAllDesktop, 'check-item-desktop');
    bindSelectAll(checkAllMobile,  'check-item-mobile');

    document.querySelectorAll('.check-item').forEach(item => {
        item.addEventListener('change', function () {
            const val = this.value;
            document.querySelectorAll(`.check-item[value="${val}"]`).forEach(c => c.checked = this.checked);
            updateDeleteButton();
        });
    });

    if (formDelete) {
        formDelete.addEventListener('submit', function (e) {
            const n = document.querySelectorAll('.check-item:checked').length;
            if (!confirm(`Hapus ${n} rekam medis secara permanen? Data tidak dapat dikembalikan.`)) {
                e.preventDefault();
            }
        });
    }
});
</script>

<footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
            <p class="text-slate-500 text-[10px] sm:text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
</x-app-layout>