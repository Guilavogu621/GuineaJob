<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Gestion des Utilisateurs</h1>
                <p class="text-[15px] text-[#888780] mt-1">Gérez et attribuez les rôles système des utilisateurs inscrits.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[15px] font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($users as $user)
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#E1F5EE] rounded-xl flex items-center justify-center text-[#0F6E56] text-[14px] font-medium uppercase">
                            {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $user->full_name }}</div>
                            <div class="text-[13px] text-[#888780]">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            @php
                                $roleBadge = match($role->name) {
                                    'admin'       => 'badge-rejected',
                                    'employeur'   => 'badge-active',
                                    'employe'     => 'badge-info',
                                    'candidat'    => 'badge-gray',
                                    'prestataire' => 'badge-warning',
                                    default       => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $roleBadge }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                        @endforeach
                    </div>

                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="mt-4">
                        @csrf
                        <select name="role" onchange="this.form.submit()"
                                class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] transition-all cursor-pointer w-full">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucun utilisateur trouvé.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle Actuel</th>
                            <th style="text-align: right;">Modifier le Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-[#E1F5EE] rounded-xl flex items-center justify-center text-[#0F6E56] font-medium text-[14px] uppercase">
                                            {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $user->full_name }}</div>
                                            <div class="text-[13px] text-[#888780]">ID: #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-[15px] text-[#2C2C2A]">{{ $user->email }}</td>
                                <td>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($user->roles as $role)
                                            @php
                                                $roleBadge = match($role->name) {
                                                    'admin'       => 'badge-rejected',
                                                    'employeur'   => 'badge-active',
                                                    'employe'     => 'badge-info',
                                                    'candidat'    => 'badge-gray',
                                                    'prestataire' => 'badge-warning',
                                                    default       => 'badge-gray',
                                                };
                                            @endphp
                                            <span class="badge {{ $roleBadge }}">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline-flex justify-end">
                                        @csrf
                                        <select name="role" onchange="this.form.submit()"
                                                class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all cursor-pointer"
                                                style="min-width: 150px;">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
