<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — Scorpio Software</title>
    @vite(['resources/css/app.css'])
    <style>
        #sidebar        { transition: transform .25s ease; }
        #main-area      { transition: margin-left .25s ease; }
        .sidebar-item   { transition: background .15s, color .15s; }
        .sidebar-item.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff !important;
        }
        .sidebar-item.active svg { color: #fff !important; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-950 min-h-screen overflow-x-hidden">

    {{-- ════════════════════════════════════════════════════════════ TOP NAV --}}
    <header class="fixed top-0 left-0 right-0 h-16 z-50
                   bg-white dark:bg-slate-900
                   border-b border-gray-200 dark:border-slate-800 shadow-sm flex items-center">
        <div class="flex items-center w-full px-4 gap-3">

            {{-- Hamburger --}}
            <button onclick="toggleSidebar()" id="hamburger"
                class="w-9 h-9 flex flex-col items-center justify-center gap-1.5 rounded-lg
                       hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors flex-shrink-0">
                <span class="block w-5 h-0.5 bg-gray-600 dark:bg-slate-400 rounded-full"></span>
                <span class="block w-5 h-0.5 bg-gray-600 dark:bg-slate-400 rounded-full"></span>
                <span class="block w-5 h-0.5 bg-gray-600 dark:bg-slate-400 rounded-full"></span>
            </button>

            {{-- Logo --}}
            <div class="flex items-center gap-2.5 flex-shrink-0">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600">
                    <img src="{{ asset('imgs/scorpiosoft-logo-new.svg') }}" alt="" class="w-full rounded-lg">
                </div>
                <div class="hidden sm:block">
                    <span class="text-gray-900 dark:text-white font-bold text-sm">Scorpio Software</span>
                    <span class="ml-1.5 text-xs text-gray-400 dark:text-slate-500">Admin</span>
                </div>
            </div>

            {{-- Right actions --}}
            <div class="ml-auto flex items-center gap-2">
                <a href="/" target="_blank"
                    class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                           text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white
                           hover:bg-gray-100 dark:hover:bg-slate-800 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Site
                </a>

                {{-- Theme toggle --}}
                <button onclick="toggleDarkMode()"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                           bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-400
                           border border-gray-200 dark:border-slate-700
                           hover:border-indigo-400 dark:hover:border-indigo-500 transition-all">
                    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 hidden"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8.66-5.34l-.7-.7M4.04 4.04l-.7-.7M21 12h-1M4 12H3m15.66 4.66l-.7.7M6.34 6.34l-.7.7M12 5a7 7 0 100 14A7 7 0 0012 5z"/>
                    </svg>
                    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <span id="themeLabel" class="hidden sm:inline">Dark</span>
                </button>

                <span class="text-gray-300 dark:text-slate-700 hidden sm:block">|</span>
                <span class="text-gray-700 dark:text-slate-300 text-sm font-medium hidden sm:block">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-xs bg-gray-100 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-500/20
                               text-gray-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400
                               border border-gray-200 dark:border-slate-700 hover:border-red-300 dark:hover:border-red-500/40
                               px-3 py-1.5 rounded-lg transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ══════════════════════════════════════════════════════════════ SIDEBAR --}}
    <aside id="sidebar"
        class="fixed left-0 top-16 bottom-0 z-40 w-64
               bg-white dark:bg-slate-900
               border-r border-gray-200 dark:border-slate-800
               flex flex-col overflow-hidden shadow-lg lg:shadow-none">

        {{-- Nav label --}}
        <div class="px-4 pt-6 pb-2">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-slate-600 px-3">
                Sections
            </p>
        </div>

        {{-- Nav items --}}
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto pb-6">
            @php
                $navItems = [
                    ['id' => 'branding', 'icon' => '🎨', 'label' => 'Branding',  'desc' => 'Name & tagline'],
                    ['id' => 'hero',     'icon' => '🚀', 'label' => 'Hero',      'desc' => 'Headline & stats'],
                    ['id' => 'services', 'icon' => '⚙️', 'label' => 'Services',  'desc' => 'Cards & header'],
                    ['id' => 'contact',  'icon' => '📬', 'label' => 'Contact',   'desc' => 'Info & hours'],
                    ['id' => 'email',    'icon' => '📧', 'label' => 'Email',     'desc' => 'SMTP & mail config'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <button id="nav-{{ $item['id'] }}"
                    onclick="showSection('{{ $item['id'] }}')"
                    class="sidebar-item w-full flex items-center gap-3 px-3 py-3 rounded-xl text-left
                           text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800">
                    <span class="text-xl w-8 flex-shrink-0 text-center leading-none">{{ $item['icon'] }}</span>
                    <div class="min-w-0">
                        <div class="font-semibold text-sm truncate">{{ $item['label'] }}</div>
                        <div class="text-xs text-gray-400 dark:text-slate-500 truncate">{{ $item['desc'] }}</div>
                    </div>
                </button>
            @endforeach
        </nav>

        {{-- Sidebar footer --}}
        <div class="border-t border-gray-100 dark:border-slate-800 p-4">
            <p class="text-xs text-gray-400 dark:text-slate-600 text-center">Scorpio Software © {{ date('Y') }}</p>
        </div>
    </aside>

    {{-- Mobile backdrop --}}
    <div id="sidebar-backdrop"
        class="fixed inset-0 bg-black/40 z-30 hidden"
        onclick="toggleSidebar()"></div>

    {{-- ══════════════════════════════════════════════════════════ MAIN CONTENT --}}
    <main id="main-area" class="pt-16 min-h-screen" style="margin-left:256px">
        <div class="max-w-4xl mx-auto p-8 space-y-6">

            {{-- ─────────────────────────────────────────── Panel breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400">
                <span>Admin</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span id="breadcrumb-label" class="text-gray-900 dark:text-white font-semibold capitalize">Branding</span>
            </div>

            @php
                $c = $sections->flatten()->pluck('value', 'key')->toArray();
                $inputClass    = 'flex-1 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500';
                $textareaClass = 'flex-1 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all resize-none leading-relaxed placeholder-gray-400 dark:placeholder-slate-500';
                $labelClass    = 'block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-2';
                $saveBtn       = 'px-4 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95 whitespace-nowrap';
                $cardClass     = 'bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-sm';
                $cardHead      = 'px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-transparent';
                $cardBody      = 'p-8 space-y-5';
                $eInput        = 'w-full bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500';
            @endphp

            {{-- ══════════════════════════════════════════════ PANEL: BRANDING --}}
            <div id="panel-branding" class="section-panel space-y-6">
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-500/10 flex items-center justify-center text-lg">🎨</div>
                        <div>
                            <h2 class="text-gray-900 dark:text-white font-bold">Branding</h2>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">Site name and tagline shown across all pages</p>
                        </div>
                    </div>
                    <div class="p-8 grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="{{ $labelClass }}">Brand Name</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-brand_name" value="{{ $c['brand_name'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('brand_name')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Tagline</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-brand_tagline" value="{{ $c['brand_tagline'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('brand_tagline')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════ PANEL: HERO --}}
            <div id="panel-hero" class="section-panel hidden space-y-6">

                {{-- Status & headline --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/10 flex items-center justify-center text-lg">🚀</div>
                        <div>
                            <h2 class="text-gray-900 dark:text-white font-bold">Hero — Main Text</h2>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">The first thing visitors read</p>
                        </div>
                    </div>
                    <div class="{{ $cardBody }}">
                        <div>
                            <label class="{{ $labelClass }}">Status Badge</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-hero_badge" value="{{ $c['hero_badge'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('hero_badge')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Main Headline</label>
                            <div class="flex gap-2 items-start">
                                <textarea id="field-hero_headline" rows="2" class="{{ $textareaClass }}">{{ $c['hero_headline'] ?? '' }}</textarea>
                                <button onclick="saveField('hero_headline')" class="{{ $saveBtn }} py-3">Save</button>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Description</label>
                            <div class="flex gap-2 items-start">
                                <textarea id="field-hero_description" rows="3" class="{{ $textareaClass }}">{{ $c['hero_description'] ?? '' }}</textarea>
                                <button onclick="saveField('hero_description')" class="{{ $saveBtn }} py-3">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }}">
                        <h3 class="text-gray-900 dark:text-white font-semibold text-sm">Stat Numbers</h3>
                        <p class="text-gray-400 dark:text-slate-500 text-xs mt-0.5">The 4 highlight numbers below the headline</p>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-5">
                        @foreach ([
                            ['key' => 'hero_stat_years',    'label' => 'Years'],
                            ['key' => 'hero_stat_projects', 'label' => 'Projects'],
                            ['key' => 'hero_stat_clients',  'label' => 'Clients'],
                            ['key' => 'hero_stat_support',  'label' => 'Support'],
                        ] as $stat)
                            <div>
                                <label class="{{ $labelClass }}">{{ $stat['label'] }}</label>
                                <div class="flex gap-2">
                                    <input type="text" id="field-{{ $stat['key'] }}" value="{{ $c[$stat['key']] ?? '' }}"
                                        class="{{ $inputClass }}">
                                    <button onclick="saveField('{{ $stat['key'] }}')"
                                        class="flex-shrink-0 w-10 h-10 flex items-center justify-center
                                               bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl
                                               transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Featured card --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }}">
                        <h3 class="text-gray-900 dark:text-white font-semibold text-sm">Featured Project Card</h3>
                        <p class="text-gray-400 dark:text-slate-500 text-xs mt-0.5">The showcase card on the right of the hero</p>
                    </div>
                    <div class="{{ $cardBody }}">
                        <div>
                            <label class="{{ $labelClass }}">Card Title</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-hero_featured_title" value="{{ $c['hero_featured_title'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('hero_featured_title')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Card Description</label>
                            <div class="flex gap-2 items-start">
                                <textarea id="field-hero_featured_desc" rows="2" class="{{ $textareaClass }}">{{ $c['hero_featured_desc'] ?? '' }}</textarea>
                                <button onclick="saveField('hero_featured_desc')" class="{{ $saveBtn }} py-3">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════ PANEL: SERVICES --}}
            <div id="panel-services" class="section-panel hidden space-y-6">

                {{-- Section header text --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 flex items-center justify-center text-lg">⚙️</div>
                        <div>
                            <h2 class="text-gray-900 dark:text-white font-bold">Services — Section Header</h2>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">The title and description above the service cards</p>
                        </div>
                    </div>
                    <div class="p-8 grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="{{ $labelClass }}">Section Subtitle</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-services_subtitle" value="{{ $c['services_subtitle'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('services_subtitle')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Section Title</label>
                            <div class="flex gap-2">
                                <input type="text" id="field-services_title" value="{{ $c['services_title'] ?? '' }}" class="{{ $inputClass }}">
                                <button onclick="saveField('services_title')" class="{{ $saveBtn }} py-2.5">Save</button>
                            </div>
                        </div>
                        <div class="sm:col-span-2 mt-1">
                            <label class="{{ $labelClass }}">Section Description</label>
                            <div class="flex gap-2 items-start">
                                <textarea id="field-services_description" rows="2" class="{{ $textareaClass }}">{{ $c['services_description'] ?? '' }}</textarea>
                                <button onclick="saveField('services_description')" class="{{ $saveBtn }} py-3">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Service cards --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div>
                            <h3 class="text-gray-900 dark:text-white font-bold">Service Cards</h3>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">{{ $services->count() }} card{{ $services->count() !== 1 ? 's' : '' }} — edit each one below</p>
                        </div>
                        <button onclick="toggleAddForm()"
                            class="ml-auto flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Card
                        </button>
                    </div>
                    <div class="p-8 space-y-5">

                        @foreach ($services as $service)
                            @php $si = 'bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500'; @endphp
                            <div id="service-card-{{ $service->id }}"
                                class="rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 overflow-hidden">

                                {{-- Card header --}}
                                <div class="flex items-center gap-3 px-6 py-3.5 border-b border-gray-100 dark:border-slate-700/60 bg-white/70 dark:bg-slate-900/50">
                                    <span class="text-xl">{{ $service->icon }}</span>
                                    <span class="text-gray-900 dark:text-white font-semibold text-sm">{{ $service->title }}</span>
                                    @if($service->popular)
                                        <span class="px-2 py-0.5 text-xs font-bold bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 rounded-full">POPULAR</span>
                                    @endif
                                    <button onclick="deleteService({{ $service->id }})"
                                        class="ml-auto flex items-center gap-1 px-3 py-1.5 text-xs text-red-500 dark:text-red-400
                                               hover:text-white hover:bg-red-500
                                               border border-red-200 dark:border-red-500/20 hover:border-red-500
                                               rounded-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </div>

                                {{-- Card fields --}}
                                <div class="p-5 space-y-4">
                                    <div class="grid sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="{{ $labelClass }}">Icon</label>
                                            <input type="text" id="svc-icon-{{ $service->id }}" value="{{ $service->icon }}" class="{{ $si }} w-full">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="{{ $labelClass }}">Title</label>
                                            <input type="text" id="svc-title-{{ $service->id }}" value="{{ $service->title }}" class="{{ $si }} w-full">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="{{ $labelClass }}">Subtitle</label>
                                        <input type="text" id="svc-subtitle-{{ $service->id }}" value="{{ $service->subtitle }}" class="{{ $si }} w-full">
                                    </div>
                                    <div>
                                        <label class="{{ $labelClass }}">Features <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(one per line)</span></label>
                                        <textarea id="svc-features-{{ $service->id }}" rows="5"
                                            class="{{ $si }} w-full resize-none font-mono leading-relaxed !py-3">{{ implode("\n", $service->features ?? []) }}</textarea>
                                    </div>
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="{{ $labelClass }}">Note <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(optional)</span></label>
                                            <input type="text" id="svc-note-{{ $service->id }}" value="{{ $service->note }}" placeholder="e.g. Customizable for cafes…" class="{{ $si }} w-full">
                                        </div>
                                        <div>
                                            <label class="{{ $labelClass }}">Price <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(optional)</span></label>
                                            <input type="text" id="svc-price-{{ $service->id }}" value="{{ $service->price }}" placeholder="e.g. $500" class="{{ $si }} w-full">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-1">
                                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                            <input type="checkbox" id="svc-popular-{{ $service->id }}" {{ $service->popular ? 'checked' : '' }}
                                                class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-indigo-500">
                                            <span class="text-sm text-gray-700 dark:text-slate-300 font-medium">Mark as Popular</span>
                                        </label>
                                        <button onclick="saveService({{ $service->id }})"
                                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-all active:scale-95">
                                            Save Card
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Add new service form --}}
                        @php $ni = 'w-full bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/40 transition-all placeholder-gray-400 dark:placeholder-slate-500'; @endphp
                        <div id="add-service-form"
                            class="hidden rounded-xl border-2 border-dashed border-indigo-400/40 dark:border-indigo-500/40
                                   bg-indigo-50/60 dark:bg-indigo-500/5 overflow-hidden">
                            <div class="px-6 py-4 border-b border-indigo-200/40 dark:border-indigo-500/20 flex items-center">
                                <span class="text-gray-900 dark:text-white font-semibold text-sm">New Service Card</span>
                                <button onclick="toggleAddForm()" class="ml-auto text-gray-400 dark:text-slate-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="grid sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="{{ $labelClass }}">Icon</label>
                                        <input type="text" id="new-icon" placeholder="🔧" class="{{ $ni }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="{{ $labelClass }}">Title</label>
                                        <input type="text" id="new-title" placeholder="Service title" class="{{ $ni }}">
                                    </div>
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">Subtitle</label>
                                    <input type="text" id="new-subtitle" placeholder="Short description" class="{{ $ni }}">
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">Features <span class="normal-case font-normal text-gray-400 dark:text-slate-500">(one per line)</span></label>
                                    <textarea id="new-features" rows="4" placeholder="Feature one&#10;Feature two&#10;Feature three"
                                        class="{{ $ni }} resize-none font-mono leading-relaxed !py-3 !h-auto"></textarea>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                        <input type="checkbox" id="new-popular"
                                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-indigo-500">
                                        <span class="text-sm text-gray-700 dark:text-slate-300 font-medium">Mark as Popular</span>
                                    </label>
                                    <button onclick="createService()"
                                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-xl transition-all active:scale-95">
                                        Create Card
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════ PANEL: CONTACT --}}
            <div id="panel-contact" class="section-panel hidden space-y-6">
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center text-lg">📬</div>
                        <div>
                            <h2 class="text-gray-900 dark:text-white font-bold">Contact Information</h2>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">Shown in the contact section</p>
                        </div>
                    </div>
                    <div class="{{ $cardBody }}">
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="{{ $labelClass }}">Email</label>
                                <div class="flex gap-2">
                                    <input type="text" id="field-contact_email" value="{{ $c['contact_email'] ?? '' }}" class="{{ $inputClass }}">
                                    <button onclick="saveField('contact_email')" class="{{ $saveBtn }} py-2.5">Save</button>
                                </div>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Phone</label>
                                <div class="flex gap-2">
                                    <input type="text" id="field-contact_phone" value="{{ $c['contact_phone'] ?? '' }}" class="{{ $inputClass }}">
                                    <button onclick="saveField('contact_phone')" class="{{ $saveBtn }} py-2.5">Save</button>
                                </div>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Working Hours</label>
                                <div class="flex gap-2">
                                    <input type="text" id="field-contact_hours" value="{{ $c['contact_hours'] ?? '' }}" class="{{ $inputClass }}">
                                    <button onclick="saveField('contact_hours')" class="{{ $saveBtn }} py-2.5">Save</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Location Description</label>
                            <div class="flex gap-2 items-start">
                                <textarea id="field-contact_location" rows="2" class="{{ $textareaClass }}">{{ $c['contact_location'] ?? '' }}</textarea>
                                <button onclick="saveField('contact_location')" class="{{ $saveBtn }} py-3">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════ PANEL: EMAIL --}}
            <div id="panel-email" class="section-panel hidden space-y-6">

                {{-- SMTP configuration --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }} flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-500/10 flex items-center justify-center text-lg">📧</div>
                        <div>
                            <h2 class="text-gray-900 dark:text-white font-bold">Email Configuration</h2>
                            <p class="text-gray-400 dark:text-slate-500 text-xs">SMTP settings for outgoing emails</p>
                        </div>
                    </div>
                    <div class="{{ $cardBody }}">

                        {{-- SMTP Server --}}
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-slate-500 mb-4">SMTP Server</p>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="{{ $labelClass }}">Host</label>
                                    <input type="text" id="email-mail_host" value="{{ $c['mail_host'] ?? '' }}"
                                        placeholder="smtp.gmail.com" class="{{ $eInput }}">
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">Port</label>
                                    <input type="text" id="email-mail_port" value="{{ $c['mail_port'] ?? '587' }}"
                                        placeholder="587" class="{{ $eInput }}">
                                </div>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Encryption</label>
                                <select id="email-mail_encryption" class="{{ $eInput }}">
                                    <option value="tls" {{ ($c['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                                    <option value="ssl" {{ ($c['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value=""    {{ ($c['mail_encryption'] ?? 'tls') === ''  ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-slate-800"></div>

                        {{-- Authentication --}}
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-slate-500 mb-4">Authentication</p>
                            <div class="space-y-4">
                                <div>
                                    <label class="{{ $labelClass }}">Username</label>
                                    <input type="text" id="email-mail_username" value="{{ $c['mail_username'] ?? '' }}"
                                        placeholder="your@email.com" class="{{ $eInput }}">
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">Password</label>
                                    <div class="relative">
                                        <input type="password" id="email-mail_password"
                                            placeholder="Leave blank to keep current"
                                            class="{{ $eInput }} pr-11">
                                        <button type="button" onclick="togglePasswordVisibility()"
                                            class="absolute right-3 top-1/2 -translate-y-1/2
                                                   text-gray-400 dark:text-slate-500 hover:text-gray-700 dark:hover:text-slate-300 transition-colors">
                                            <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-400 dark:text-slate-600 mt-1.5">Leave blank to keep the current password unchanged</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-slate-800"></div>

                        {{-- Sender identity --}}
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-slate-500 mb-4">Sender Identity</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="{{ $labelClass }}">From Address</label>
                                    <input type="text" id="email-mail_from_address" value="{{ $c['mail_from_address'] ?? '' }}"
                                        placeholder="info@scorpiosoft.tech" class="{{ $eInput }}">
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">From Name</label>
                                    <input type="text" id="email-mail_from_name" value="{{ $c['mail_from_name'] ?? '' }}"
                                        placeholder="Scorpio Software" class="{{ $eInput }}">
                                </div>
                            </div>
                        </div>

                        {{-- Save button --}}
                        <div class="flex justify-end pt-2">
                            <button onclick="saveEmailConfig()"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95">
                                Save Configuration
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Test email --}}
                <div class="{{ $cardClass }}">
                    <div class="{{ $cardHead }}">
                        <h3 class="text-gray-900 dark:text-white font-semibold text-sm">Send Test Email</h3>
                        <p class="text-gray-400 dark:text-slate-500 text-xs mt-0.5">Verify your SMTP settings are working</p>
                    </div>
                    <div class="p-8">
                        <div class="flex gap-3">
                            <input type="email" id="test-email-to" placeholder="recipient@example.com"
                                class="{{ $eInput }}">
                            <button id="send-test-btn" onclick="sendTestEmail()"
                                class="flex-shrink-0 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-xl transition-all active:scale-95 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                                Send Test
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Toast --}}
    <div id="toast"
        class="fixed bottom-6 right-6 px-5 py-3 rounded-xl font-medium text-sm text-white shadow-2xl pointer-events-none z-50"
        style="transition:all .3s ease; transform:translateY(4rem); opacity:0">
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        // ── Dark mode ────────────────────────────────────────────────────────
        let isDark = document.documentElement.classList.contains('dark');

        function applyTheme() {
            document.documentElement.classList.toggle('dark', isDark);
            document.getElementById('sunIcon').classList.toggle('hidden', !isDark);
            document.getElementById('moonIcon').classList.toggle('hidden', isDark);
            document.getElementById('themeLabel').textContent = isDark ? 'Light' : 'Dark';
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        function toggleDarkMode() { isDark = !isDark; applyTheme(); }
        applyTheme();

        // ── Sidebar ──────────────────────────────────────────────────────────
        let sidebarOpen = true;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            applySidebarState();
            localStorage.setItem('admin-sidebar', sidebarOpen ? 'open' : 'closed');
        }

        function applySidebarState() {
            const sidebar   = document.getElementById('sidebar');
            const main      = document.getElementById('main-area');
            const backdrop  = document.getElementById('sidebar-backdrop');
            const isMobile  = window.innerWidth < 1024;

            if (sidebarOpen) {
                sidebar.style.transform  = 'translateX(0)';
                main.style.marginLeft    = isMobile ? '0' : '256px';
                backdrop.classList.toggle('hidden', !isMobile);
            } else {
                sidebar.style.transform  = 'translateX(-100%)';
                main.style.marginLeft    = '0';
                backdrop.classList.add('hidden');
            }
        }

        // Restore sidebar state
        const savedSidebar = localStorage.getItem('admin-sidebar');
        if (savedSidebar === 'closed') { sidebarOpen = false; }
        if (window.innerWidth < 1024)  { sidebarOpen = false; }
        applySidebarState();

        window.addEventListener('resize', () => {
            if (!sidebarOpen) return;
            document.getElementById('main-area').style.marginLeft =
                window.innerWidth >= 1024 ? '256px' : '0';
        });

        // ── Section switching ────────────────────────────────────────────────
        function showSection(id) {
            document.querySelectorAll('.section-panel').forEach(el => el.classList.add('hidden'));
            document.getElementById('panel-' + id)?.classList.remove('hidden');

            document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
            document.getElementById('nav-' + id)?.classList.add('active');

            const labels = { branding: 'Branding', hero: 'Hero', services: 'Services', contact: 'Contact', email: 'Email' };
            document.getElementById('breadcrumb-label').textContent = labels[id] ?? id;

            localStorage.setItem('admin-section', id);

            // Close sidebar on mobile after selecting
            if (window.innerWidth < 1024 && sidebarOpen) toggleSidebar();
        }

        // Restore last section
        const lastSection = localStorage.getItem('admin-section') || 'branding';
        showSection(lastSection);

        // ── Content fields ───────────────────────────────────────────────────
        function saveField(key) {
            fetch('{{ route('admin.content.update') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body:    JSON.stringify({ key, value: document.getElementById('field-' + key).value }),
            })
            .then(r => r.json())
            .then(d => d.success ? showToast('✓  Saved') : showToast('Save failed', true))
            .catch(() => showToast('Connection error', true));
        }

        // ── Service cards ────────────────────────────────────────────────────
        function saveService(id) {
            fetch(`/admin/services/${id}`, {
                method:  'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
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
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body:    JSON.stringify(data),
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) { showToast('✓  Created — reload to edit'); toggleAddForm(); }
                else showToast('Create failed', true);
            })
            .catch(() => showToast('Connection error', true));
        }

        // ── Email config ─────────────────────────────────────────────────────
        function togglePasswordVisibility() {
            const input = document.getElementById('email-mail_password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            document.getElementById('eye-open').classList.toggle('hidden', isHidden);
            document.getElementById('eye-closed').classList.toggle('hidden', !isHidden);
        }

        function saveEmailConfig() {
            const password = document.getElementById('email-mail_password').value;
            const data = {
                mail_host:         document.getElementById('email-mail_host').value,
                mail_port:         document.getElementById('email-mail_port').value,
                mail_encryption:   document.getElementById('email-mail_encryption').value,
                mail_username:     document.getElementById('email-mail_username').value,
                mail_from_address: document.getElementById('email-mail_from_address').value,
                mail_from_name:    document.getElementById('email-mail_from_name').value,
            };
            if (password) data.mail_password = password;

            fetch('{{ route('admin.email.update') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body:    JSON.stringify(data),
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    document.getElementById('email-mail_password').value = '';
                    showToast('✓  Email configuration saved');
                } else {
                    showToast('Save failed', true);
                }
            })
            .catch(() => showToast('Connection error', true));
        }

        function sendTestEmail() {
            const to  = document.getElementById('test-email-to').value.trim();
            const btn = document.getElementById('send-test-btn');
            if (!to) { showToast('Enter a recipient email', true); return; }

            btn.disabled    = true;
            btn.textContent = 'Sending…';

            fetch('{{ route('admin.email.test') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body:    JSON.stringify({ to }),
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) showToast('✓  Test email sent successfully');
                else           showToast(d.error || 'Failed to send', true);
            })
            .catch(() => showToast('Connection error', true))
            .finally(() => { btn.disabled = false; btn.textContent = 'Send Test'; });
        }

        // ── Toast ────────────────────────────────────────────────────────────
        function showToast(msg, isError = false) {
            const t = document.getElementById('toast');
            t.textContent      = msg;
            t.style.background = isError ? '#ef4444' : '#10b981';
            t.style.boxShadow  = isError ? '0 10px 30px rgba(239,68,68,.35)' : '0 10px 30px rgba(16,185,129,.35)';
            t.style.transform  = 'translateY(0)';
            t.style.opacity    = '1';
            clearTimeout(t._t);
            t._t = setTimeout(() => { t.style.transform = 'translateY(4rem)'; t.style.opacity = '0'; }, 2500);
        }
    </script>

</body>
</html>
