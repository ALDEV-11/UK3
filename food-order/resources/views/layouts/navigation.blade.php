<nav x-data="{ open: false }" style="background-color: #FFF; border-bottom: 3px solid #E8612A;">
    @php($role = Auth::user()?->role)
    @php($ulasanCount = $role === 'pelanggan' ? (int) (Auth::user()?->ulasan()->count() ?? 0) : 0)
    @php($isUlasanActive = request()->routeIs('pelanggan.ulasan.*'))
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" style="color: #E8612A;" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if ($role === 'admin')
                        <x-nav-link :href="route('admin.restoran.index')" :active="request()->routeIs('admin.restoran.*')">Restoran</x-nav-link>
                        <x-nav-link :href="route('admin.menu.index')" :active="request()->routeIs('admin.menu.*')">Menu</x-nav-link>
                        <x-nav-link :href="route('admin.kategori.index')" :active="request()->routeIs('admin.kategori.*')">Kategori</x-nav-link>
                        <x-nav-link :href="route('admin.voucher.index')" :active="request()->routeIs('admin.voucher.*')">Voucher</x-nav-link>
                        <x-nav-link :href="route('admin.kurir.index')" :active="request()->routeIs('admin.kurir.*')">Kurir</x-nav-link>
                        <x-nav-link :href="route('admin.pesanan.index')" :active="request()->routeIs('admin.pesanan.*')">Pesanan</x-nav-link>
                        <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">Laporan</x-nav-link>
                    @elseif ($role === 'restoran')
                        <x-nav-link :href="route('restoran.menu.index')" :active="request()->routeIs('restoran.menu.*')">Menu</x-nav-link>
                        <x-nav-link :href="route('restoran.kategori.index')" :active="request()->routeIs('restoran.kategori.*')">Kategori</x-nav-link>
                        <x-nav-link :href="route('restoran.pesanan.index')" :active="request()->routeIs('restoran.pesanan.*')">Pesanan</x-nav-link>
                        <x-nav-link :href="route('restoran.laporan.index')" :active="request()->routeIs('restoran.laporan.*')">Laporan</x-nav-link>
                        <x-nav-link :href="route('restoran.jadwal.edit')" :active="request()->routeIs('restoran.jadwal.*')">Jadwal</x-nav-link>
                    @else
                        <x-nav-link :href="route('pelanggan.menu.search')" :active="request()->routeIs('pelanggan.menu.search') || request()->routeIs('menu.search') || request()->routeIs('restoran.public.show')">Menu</x-nav-link>
                        <x-nav-link :href="route('pelanggan.keranjang.index')" :active="request()->routeIs('pelanggan.keranjang.*')">Keranjang</x-nav-link>
                        <x-nav-link :href="route('pelanggan.pesanan.index')" :active="request()->routeIs('pelanggan.pesanan.*')">Pesanan</x-nav-link>
                        <x-nav-link :href="route('pelanggan.ulasan.index')" :active="request()->routeIs('pelanggan.ulasan.*')">
                            <span class="inline-flex items-center gap-1.5">
                                <span>Ulasan</span>
                                @if($ulasanCount > 0)
                                    <span class="pointer-events-none inline-flex min-w-5 items-center justify-center rounded-full px-1.5 py-0.5 text-[10px] font-bold leading-none text-white {{ $isUlasanActive ? 'bg-emerald-600' : 'bg-indigo-600' }}">{{ $ulasanCount }}</span>
                                @endif
                            </span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="notifDropdown()" x-init="init()" @click.outside="dropdownOpen = false">
                    <button type="button"
                        class="relative inline-flex items-center rounded-md px-3 py-2 text-sm text-gray-600 hover:text-gray-800"
                        title="Notifikasi"
                        @click="dropdownOpen = !dropdownOpen">
                        <span>🔔</span>
                        <span x-show="unreadCount > 0"
                            class="absolute -right-1 -top-1 min-w-5 rounded-full bg-rose-500 px-1.5 py-0.5 text-center text-[10px] font-bold text-white"
                            x-text="unreadCount"></span>
                    </button>

                    <div x-show="dropdownOpen"
                        x-transition
                        class="absolute right-0 z-50 mt-2 w-96 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
                        style="display: none;">
                        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                            <p class="text-sm font-semibold text-gray-800">Notifikasi</p>
                            <button type="button"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 disabled:opacity-50"
                                @click="markAllAsRead"
                                :disabled="isLoading || unreadCount === 0">
                                Tandai semua dibaca
                            </button>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            <template x-if="isLoading">
                                <div class="px-4 py-4 text-xs text-gray-500">Memuat notifikasi...</div>
                            </template>

                            <template x-if="!isLoading && notifications.length === 0">
                                <div class="px-4 py-4 text-xs text-gray-500">Belum ada notifikasi.</div>
                            </template>

                            <template x-for="item in notifications" :key="item.id">
                                <a :href="item.data?.url || '#'"
                                    class="block border-b border-gray-100 px-4 py-3 hover:bg-gray-50"
                                    :class="item.read_at ? 'bg-white' : 'bg-amber-50'"
                                    @click="markAsRead(item.id)">
                                    <p class="text-sm font-medium text-gray-800" x-text="item.data?.pesan || 'Notifikasi baru'"></p>
                                    <p class="mt-1 text-[11px] text-gray-500" x-text="formatDate(item.created_at)"></p>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md" style="background-color: #FFF8F3; color: #2C1810;" onmouseover="this.style.backgroundColor='#F5A623';this.style.color='#2C1810';" onmouseout="this.style.backgroundColor='#FFF8F3';this.style.color='#2C1810';">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background-color: #2C1810;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if ($role === 'admin')
                <x-responsive-nav-link :href="route('admin.restoran.index')" :active="request()->routeIs('admin.restoran.*')">Restoran</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.menu.index')" :active="request()->routeIs('admin.menu.*')">Menu</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kategori.index')" :active="request()->routeIs('admin.kategori.*')">Kategori</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.voucher.index')" :active="request()->routeIs('admin.voucher.*')">Voucher</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kurir.index')" :active="request()->routeIs('admin.kurir.*')">Kurir</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pesanan.index')" :active="request()->routeIs('admin.pesanan.*')">Pesanan</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">Laporan</x-responsive-nav-link>
            @elseif ($role === 'restoran')
                <x-responsive-nav-link :href="route('restoran.menu.index')" :active="request()->routeIs('restoran.menu.*')">Menu</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('restoran.kategori.index')" :active="request()->routeIs('restoran.kategori.*')">Kategori</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('restoran.pesanan.index')" :active="request()->routeIs('restoran.pesanan.*')">Pesanan</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('restoran.laporan.index')" :active="request()->routeIs('restoran.laporan.*')">Laporan</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('restoran.jadwal.edit')" :active="request()->routeIs('restoran.jadwal.*')">Jadwal</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('restoran.profil.edit')" :active="request()->routeIs('restoran.profil.*')">Profil</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('pelanggan.menu.search')" :active="request()->routeIs('pelanggan.menu.search') || request()->routeIs('menu.search') || request()->routeIs('restoran.public.show')">Menu</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pelanggan.keranjang.index')" :active="request()->routeIs('pelanggan.keranjang.*')">Keranjang</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pelanggan.pesanan.index')" :active="request()->routeIs('pelanggan.pesanan.*')">Pesanan</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pelanggan.ulasan.index')" :active="request()->routeIs('pelanggan.ulasan.*')">
                    <span class="inline-flex items-center gap-1.5">
                        <span>Ulasan</span>
                        @if($ulasanCount > 0)
                            <span class="pointer-events-none inline-flex min-w-5 items-center justify-center rounded-full px-1.5 py-0.5 text-[10px] font-bold leading-none text-white {{ $isUlasanActive ? 'bg-emerald-600' : 'bg-indigo-600' }}">{{ $ulasanCount }}</span>
                        @endif
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pelanggan.pesanan.index')" :active="request()->routeIs('pelanggan.pesanan.*')">Lacak Pesanan</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t" style="border-color: #E8612A;">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
<style>
    nav .sm\:flex a, nav .sm\:flex button, nav .sm\:flex .dropdown-toggle {
        color: #E8612A !important;
        font-weight: 600;
        border-radius: 0.5rem;
        padding: 0.5rem 1.25rem;
        transition: color 0.2s, border-bottom 0.2s;
        background: transparent;
        text-decoration: none;
        box-shadow: none;
    }
    nav .sm\:flex a:hover, nav .sm\:flex button:hover, nav .sm\:flex .dropdown-toggle:hover {
        background: transparent !important;
        color: #F5A623 !important;
        text-decoration: underline;
        text-underline-offset: 4px;
        box-shadow: none;
    }
    nav .sm\:flex .active {
        background: transparent !important;
        color: #F5A623 !important;
        text-decoration: underline;
        text-underline-offset: 4px;
    }
    nav .dropdown-menu {
        background-color: #FFF8F3 !important;
        color: #2C1810 !important;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(44,24,16,0.08);
    }
    nav .dropdown-menu a:hover {
        background-color: #F5A623 !important;
        color: #E8612A !important;
    }
</style>
</nav>

<script>
    function notifDropdown() {
        return {
            dropdownOpen: false,
            notifications: [],
            unreadCount: 0,
            isLoading: false,
            pollingTimer: null,

            async init() {
                await Promise.all([this.fetchUnreadCount(), this.fetchNotifications()]);
                this.pollingTimer = setInterval(() => this.fetchUnreadCount(), 30000);
            },

            async fetchUnreadCount() {
                try {
                    const response = await fetch("{{ route('api.notifikasi.unread-count') }}", {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });

                    const data = await response.json();
                    if (!response.ok) return;

                    this.unreadCount = Number(data.count || 0);
                } catch (error) {
                    // silent fail untuk polling ringan
                }
            },

            async fetchNotifications() {
                this.isLoading = true;

                try {
                    const response = await fetch("{{ route('api.notifikasi.index') }}", {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });

                    const data = await response.json();
                    if (!response.ok) return;

                    this.notifications = Array.isArray(data.data) ? data.data : [];
                } catch (error) {
                    this.notifications = [];
                } finally {
                    this.isLoading = false;
                }
            },

            async markAsRead(id) {
                try {
                    await fetch(`/api/notifikasi/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                        credentials: 'same-origin',
                    });
                } catch (error) {
                    // ignore
                } finally {
                    await Promise.all([this.fetchUnreadCount(), this.fetchNotifications()]);
                }
            },

            async markAllAsRead() {
                try {
                    await fetch("{{ route('api.notifikasi.read-all') }}", {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        },
                        credentials: 'same-origin',
                    });
                } catch (error) {
                    // ignore
                } finally {
                    await Promise.all([this.fetchUnreadCount(), this.fetchNotifications()]);
                }
            },

            formatDate(value) {
                if (!value) return '-';

                return new Intl.DateTimeFormat('id-ID', {
                    dateStyle: 'medium',
                    timeStyle: 'short',
                }).format(new Date(value));
            },
        }
    }

    (function () {
        // fallback polling kecil jika dropdown tidak aktif dirender
        const fetchUnreadCount = async () => {
            try {
                const response = await fetch("{{ route('api.notifikasi.unread-count') }}", {
                    headers: {
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();
                if (!response.ok) return;

                const badgeEl = document.querySelector('[x-data="notifDropdown()"] span.absolute');
                if (!badgeEl) return;

                const total = Number(data.count || 0);
                badgeEl.textContent = String(total);
                badgeEl.style.display = total > 0 ? 'inline-block' : 'none';
            } catch (error) {
                // silent fail untuk polling navbar
            }
        };
    })();
</script>
