<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Utilisateurs & Rôles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-[#E1F5EE] border-l-4 border-[#0F6E56] text-[#085041] rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Utilisateur</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Rôle Actuel</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Modifier le Rôle</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-guinea-green/10 flex items-center justify-center text-guinea-green font-bold">
                                                    {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                                </div>
                                                <div class="ms-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $user->full_name }}</div>
                                                    <div class="text-xs text-gray-500">ID: #{{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @foreach($user->roles as $role)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                    {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $role->name === 'employeur' ? 'bg-guinea-gold/20 text-orange-800' : '' }}
                                                    {{ $role->name === 'employe' ? 'bg-guinea-green/20 text-guinea-green' : '' }}
                                                    {{ $role->name === 'candidat' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ strtoupper($role->name) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <select name="role" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 focus:border-guinea-green focus:ring-guinea-green">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                            {{ strtoupper($role->name) }}
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
        </div>
    </div>
</x-app-layout>
