<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Anti-flash: apply theme before CSS renders to prevent white flash --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard — Scorpio Software</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-200">

    {{-- Top Nav --}}
    <nav class="fixed top-0 w-full z-50 bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <img src="{{ asset('imgs/scorpiosoft-logo.png') }}" alt="" class="w-full rounded-lg">
                </div>
                <div>
                    <span class="text-gray-900 dark:text-white font-bold text-sm">Scorpio Software</span>
                    <span class="ml-2 text-xs text-gray-500 dark:text-slate-400 font-medium">Admin Panel</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="/" target="_blank"
                    class="text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white text-sm flex items-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Site
                </a>

                {{-- Theme toggle --}}
                <button onclick="toggleDarkMode()"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-400 border border-gray-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all">
                    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-5.34l-.7-.7M4.04 4.04l-.7-.7M21 12h-1M4 12H3m15.66 4.66l-.7.7M6.34 6.34l-.7-.7M12 5a7 7 0 100 14A7 7 0 0012 5z"/>
                    </svg>
                    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <span id="themeLabel">Dark</span>
                </button>

                <span class="text-gray-200 dark:text-slate-700">|</span>
                <span class="text-gray-700 dark:text-slate-300 text-sm font-medium">{{ auth()->user()->name }}</span>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-xs bg-gray-100 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-500/20 text-gray-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 border border-gray-200 dark:border-slate-700 hover:border-red-300 dark:hover:border-red-500/40 px-3 py-1.5 rounded-lg transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Section Quick-Nav --}}
    <div class="fixed top-16 w-full z-40 bg-white/90 dark:bg-slate-950/80 backdrop-blur border-b border-gray-200 dark:border-slate-800">
        <div class="max-w-5xl mx-auto px-4 h-10 flex items-center gap-1">
            @foreach ($sections->keys() as $sectionKey)
                <a href="#section-{{ $sectionKey }}"
                    class="px-3 py-1 rounded-md text-xs font-medium text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-800 transition-all capitalize">
                    {{ $sectionKey }}
                </a>
            @endforeach
            <a href="#section-services"
                class="px-3 py-1 rounded-md text-xs font-medium text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-800 transition-all">
                Services
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="max-w-5xl mx-auto pt-32 pb-20 px-4 space-y-8">

        @foreach ($sections as $sectionKey => $fields)
            @php
                $icons = [
                    'branding' => ['icon' => '🎨', 'color' => 'from-purple-500 to-pink-500',  'bg' => 'bg-purple-500/10'],
                    'hero'     => ['icon' => '🚀', 'color' => 'from-indigo-500 to-blue-500',   'bg' => 'bg-indigo-500/10'],
                    'services' => ['icon' => '⚙️', 'color' => 'from-cyan-500 to-teal-500',     'bg' => 'bg-cyan-500/10'],
                    'contact'  => ['icon' => '📬', 'color' => 'from-emerald-500 to-green-500', 'bg' => 'bg-emerald-500/10'],
                ];
                $meta = $icons[$sectionKey] ?? ['icon' => '📝', 'color' => 'from-gray-500 to-gray-600', 'bg' => 'bg-gray-500/10'];
            @endphp

            <div id="section-{{ $sectionKey }}"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-sm dark:shadow-xl">

                {{-- Section Header --}}
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-transparent flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl {{ $meta['bg'] }} flex items-center justify-center text-lg">
                        {{ $meta['icon'] }}
                    </div>
                    <div>
                        <h2 class="text-gray-900 dark:text-white font-bold capitalize">{{ $sectionKey }}</h2>
                        <p class="text-gray-400 dark:text-slate-500 text-xs">{{ $fields->count() }} field{{ $fields->count() > 1 ? 's' : '' }}</p>
                    </div>
                    <div class="ml-auto">
                        <span class="inline-block w-2 h-2 rounded-full bg-gradient-to-r {{ $meta['color'] }}"></span>
                    </div>
                </div>

                {{-- Fields --}}
                <div class="p-8 space-y-6">
                    @php
                        $textFields     = $fields->where('type', 'text');
                        $textareaFields = $fields->where('type', 'textarea');
                    @endphp

                    @if ($textFields->isNotEmpty())
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach ($textFields as $field)
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">
                                        {{ $field->label }}
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text"
                                            id="field-{{ $field->key }}"
                                            value="{{ $field->value }}"
                                            class="flex-1 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                                        <button onclick="saveField('{{ $field->key }}')"
                                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95 whitespace-nowrap">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @foreach ($textareaFields as $field)
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2">
                                {{ $field->label }}
                            </label>
                            <div class="flex gap-2 items-start">
                                <textarea
                                    id="field-{{ $field->key }}"
                                    rows="3"
                                    class="flex-1 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all resize-none placeholder-gray-400 dark:placeholder-slate-500 leading-relaxed">{{ $field->value }}</textarea>
                                <button onclick="saveField('{{ $field->key }}')"
                                    class="px-4 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95 whitespace-nowrap">
                                    Save
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- ── Services Section ─────────────────────────────────────────────── --}}
        <div id="section-services"
            class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-sm dark:shadow-xl">

            <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-transparent flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 flex items-center justify-center text-lg">⚙️</div>
                <div>
                    <h2 class="text-gray-900 dark:text-white font-bold">Services</h2>
                    <p class="text-gray-400 dark:text-slate-500 text-xs">{{ $services->count() }} service card{{ $services->count() !== 1 ? 's' : '' }}</p>
                </div>
                <button onclick="toggleAddForm()"
                    class="ml-auto flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Service
                </button>
            </div>

            <div class="p-8 space-y-6">

                @foreach ($services as $service)
                    <div id="service-card-{{ $service->id }}"
                        class="rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/60 overflow-hidden">

                        {{-- Card header --}}
                        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700/60 bg-white/60 dark:bg-transparent">
                            <span class="text-2xl">{{ $service->icon }}</span>
                            <span class="text-gray-900 dark:text-white font-semibold">{{ $service->title }}</span>
                            @if($service->popular)
                                <span class="px-2 py-0.5 text-xs font-bold bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 rounded-full">POPULAR</span>
                            @endif
                            <button onclick="deleteService({{ $service->id }})"
                                class="ml-auto flex items-center gap-1 px-3 py-1.5 text-xs text-red-500 dark:text-red-400 hover:text-white hover:bg-red-500 dark:hover:bg-red-500/20 border border-red-200 dark:border-red-500/20 hover:border-red-500 dark:hover:border-red-500/50 rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </div>

                        {{-- Card fields --}}
                        <div class="p-6 space-y-4">
                            <div class="grid sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Icon</label>
                                    <input type="text" id="svc-icon-{{ $service->id }}" value="{{ $service->icon }}"
                                        class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Title</label>
                                    <input type="text" id="svc-title-{{ $service->id }}" value="{{ $service->title }}"
                                        class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Subtitle</label>
                                <input type="text" id="svc-subtitle-{{ $service->id }}" value="{{ $service->subtitle }}"
                                    class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                    Features <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(one per line)</span>
                                </label>
                                <textarea id="svc-features-{{ $service->id }}" rows="5"
                                    class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all resize-none font-mono leading-relaxed">{{ implode("\n", $service->features ?? []) }}</textarea>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Note <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(optional)</span></label>
                                    <input type="text" id="svc-note-{{ $service->id }}" value="{{ $service->note }}"
                                        placeholder="e.g. Customizable for cafes…"
                                        class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Price <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(optional)</span></label>
                                    <input type="text" id="svc-price-{{ $service->id }}" value="{{ $service->price }}"
                                        placeholder="e.g. $500"
                                        class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="checkbox" id="svc-popular-{{ $service->id }}" {{ $service->popular ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-indigo-500 focus:ring-indigo-500/40">
                                    <span class="text-sm text-gray-700 dark:text-slate-300 font-medium">Mark as Popular</span>
                                </label>
                                <button onclick="saveService({{ $service->id }})"
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95">
                                    Save Service
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Add new service form --}}
                <div id="add-service-form" class="hidden rounded-xl border-2 border-dashed border-indigo-400/40 dark:border-indigo-500/40 bg-indigo-50/50 dark:bg-indigo-500/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-indigo-200/50 dark:border-indigo-500/20 flex items-center gap-2">
                        <span class="text-gray-900 dark:text-white font-semibold text-sm">New Service</span>
                        <button onclick="toggleAddForm()" class="ml-auto text-gray-400 dark:text-slate-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Icon</label>
                                <input type="text" id="new-icon" placeholder="🔧"
                                    class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Title</label>
                                <input type="text" id="new-title" placeholder="Service title"
                                    class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Subtitle</label>
                            <input type="text" id="new-subtitle" placeholder="Short description"
                                class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">
                                Features <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(one per line)</span>
                            </label>
                            <textarea id="new-features" rows="4" placeholder="Feature one&#10;Feature two&#10;Feature three"
                                class="w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all resize-none font-mono leading-relaxed placeholder-gray-400 dark:placeholder-slate-500"></textarea>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" id="new-popular"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-indigo-500 focus:ring-indigo-500/40">
                                <span class="text-sm text-gray-700 dark:text-slate-300 font-medium">Mark as Popular</span>
                            </label>
                            <button onclick="createService()"
                                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-emerald-500/20 active:scale-95">
                                Create Service
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    {{-- Toast --}}
    <div id="toast"
        class="fixed bottom-6 right-6 px-5 py-3 rounded-xl font-medium text-sm text-white shadow-2xl pointer-events-none transition-all duration-300"
        style="transform: translateY(4rem); opacity: 0;">
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // ── Dark mode ─────────────────────────────────────────────────────────
        let isDark = document.documentElement.classList.contains('dark');

        function applyTheme() {
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.getElementById('sunIcon').classList.remove('hidden');
                document.getElementById('moonIcon').classList.add('hidden');
                document.getElementById('themeLabel').textContent = 'Light';
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('sunIcon').classList.add('hidden');
                document.getElementById('moonIcon').classList.remove('hidden');
                document.getElementById('themeLabel').textContent = 'Dark';
            }
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        function toggleDarkMode() {
            isDark = !isDark;
            applyTheme();
        }

        applyTheme(); // sync button icons with current state

        // ── Site content fields ───────────────────────────────────────────────
        function saveField(key) {
            fetch('{{ route('admin.content.update') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body:    JSON.stringify({ key, value: document.getElementById('field-' + key).value }),
            })
            .then(r => r.json())
            .then(d => d.success ? showToast('✓  Saved') : showToast('Save failed', true))
            .catch(() => showToast('Connection error', true));
        }

        // ── Service cards ─────────────────────────────────────────────────────
        function saveService(id) {
            fetch(`/admin/services/${id}`, {
                method:  'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({
                    icon:     document.getElementById('svc-icon-'     + id)?.value ?? '',
                    title:    document.getElementById('svc-title-'    + id).value,
                    subtitle: document.getElementById('svc-subtitle-' + id).value,
                    features: document.getElementById('svc-features-' + id).value,
                    note:     document.getElementById('svc-note-'     + id)?.value ?? '',
                    price:    document.getElementById('svc-price-'    + id)?.value ?? '',
                    popular:  document.getElementById('svc-popular-'  + id).checked,
                }),
            })
            .then(r => r.json())
            .then(d => d.success ? showToast('✓  Service saved') : showToast('Save failed', true))
            .catch(() => showToast('Connection error', true));
        }

        function deleteService(id) {
            if (!confirm('Delete this service card? This cannot be undone.')) return;
            fetch(`/admin/services/${id}`, {
                method:  'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) { document.getElementById('service-card-' + id)?.remove(); showToast('✓  Deleted'); }
                else showToast('Delete failed', true);
            })
            .catch(() => showToast('Connection error', true));
        }

        function toggleAddForm() {
            const form = document.getElementById('add-service-form');
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function createService() {
            const data = {
                icon:     document.getElementById('new-icon').value,
                title:    document.getElementById('new-title').value,
                subtitle: document.getElementById('new-subtitle').value,
                features: document.getElementById('new-features').value,
                popular:  document.getElementById('new-popular').checked,
            };
            if (!data.title.trim()) { showToast('Title is required', true); return; }
            fetch('/admin/services', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body:    JSON.stringify(data),
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) { showToast('✓  Service created — reload to edit it'); toggleAddForm(); }
                else showToast('Create failed', true);
            })
            .catch(() => showToast('Connection error', true));
        }

        // ── Toast ─────────────────────────────────────────────────────────────
        function showToast(msg, isError = false) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.style.background = isError ? '#ef4444' : '#10b981';
            toast.style.boxShadow  = isError ? '0 10px 40px rgba(239,68,68,.3)' : '0 10px 40px rgba(16,185,129,.3)';
            toast.style.transform  = 'translateY(0)';
            toast.style.opacity    = '1';
            clearTimeout(toast._t);
            toast._t = setTimeout(() => {
                toast.style.transform = 'translateY(4rem)';
                toast.style.opacity   = '0';
            }, 2500);
        }
    </script>

</body>
</html>
