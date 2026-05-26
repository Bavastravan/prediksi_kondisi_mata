<x-app-layout>
    <div class="py-12 bg-slate-900 min-h-screen text-slate-100">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-black text-white tracking-tight">Arsip & Riwayat Pemeriksaan Klinis</h1>
                <p class="text-slate-400 text-sm mt-2">Menampilkan seluruh rekam medis Anda berbasis Double Validation Pipeline AI.</p>
            </div>

            <div class="bg-slate-800 rounded-3xl p-8 border border-slate-700 shadow-2xl">
                
                <div class="mb-6 flex justify-between items-center">
                    <div class="inline-flex bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-emerald-500/20">
                        Database Sinkronisasi Aktif
                    </div>
                </div>

                <div class="overflow-x-auto bg-slate-800/50 p-1 rounded-2xl border border-slate-700/60 flex flex-col justify-between">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs uppercase bg-slate-950 text-emerald-400 tracking-wider border-b border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4">Sesi & Waktu Pemeriksaan</th>
                                <th scope="col" class="px-6 py-4">Usia Pasien</th>
                                <th scope="col" class="px-6 py-4">Kesimpulan Akhir</th>
                                <th scope="col" class="px-6 py-4 text-center">Tingkat Keyakinan</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse ($diagnoses as $item)
                                <tr class="hover:bg-slate-800 transition-colors duration-200">
                                    <td class="px-6 py-4 font-mono text-xs">
                                        <span class="text-white block font-bold tracking-widest mb-1">#EXM-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-slate-400">{{ $item->created_at->format('d M Y | H:i') }} WIB</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-slate-300 font-bold">
                                        {{ $item->age }} <span class="text-xs font-normal text-slate-400">Tahun</span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if(str_contains(strtolower($item->result), 'gagal'))
                                            <span class="inline-flex bg-rose-500/10 text-rose-400 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide border border-rose-500/20">
                                                <i class="fa-solid fa-triangle-exclamation mr-1.5 mt-0.5"></i> {{ $item->result }}
                                            </span>
                                        @elseif(str_contains(strtolower($item->result), 'normal') || str_contains(strtolower($item->result), 'sehat'))
                                            <span class="inline-flex bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide border border-emerald-500/20">
                                                <i class="fa-solid fa-check-circle mr-1.5 mt-0.5"></i> {{ $item->result }}
                                            </span>
                                        @else
                                            <span class="inline-flex bg-amber-500/10 text-amber-400 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide border border-amber-500/20">
                                                <i class="fa-solid fa-eye-dropper mr-1.5 mt-0.5"></i> {{ $item->result }}
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <div class="w-16 bg-slate-700 h-2 rounded-full overflow-hidden">
                                                <div class="bg-emerald-500 h-full transition-all duration-300" style="width: {{ $item->confidence }}%"></div>
                                            </div>
                                            <span class="font-mono text-xs font-black text-white">{{ $item->confidence }}%</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('riwayat.pdf', $item->id) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition-all shadow-md active:scale-95">
                                            <i class="fa-solid fa-print"></i> Cetak Laporan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-3 border border-emerald-500/30 shadow-inner">
                                            <i class="fa-solid fa-folder-open text-2xl"></i>
                                        </div>
                                        <h3 class="text-base font-bold text-white uppercase tracking-wider mt-4">Belum Ada Riwayat</h3>
                                        <p class="text-xs text-slate-400 mt-2">Anda belum pernah melakukan sesi skrining atau diagnosa mata.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-700">
                    {{ $diagnoses->links() }}
                </div>

            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('diagnosa.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-bold transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Diagnosa AI Baru
                </a>
            </div>

        </div>
    </div>
</x-app-layout>