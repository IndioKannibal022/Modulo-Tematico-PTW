<!-- Sidebar -->
<div class="w-64 bg-sidebar border-r border-gray-200 h-full flex flex-col">
    <div class="border border-gray-300 rounded-xl p-2 space-y-1 bg-white">
        <div class="p-6 border-b border-gray-200">

         <h2 class="font-semibold text-lg text-gray-800">Utilizador</h2>

        </div>

        <nav class="flex-1 p-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{route('perfil-Compras')}}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
                    {{ request()->is('paginas/perfil/minhas_compras') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Minhas Compras</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('perfil-Anuncios')}}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
                    {{ request()->is('perfil/meus_anuncios') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Meus Anuncios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('perfil-Comentarios') }}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
    {{ request()->is('paginas/perfil/comentarios') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2M15 3h-6a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2z" />
                        </svg>
                        <span>Comentários Meu Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('perfilPage')}}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
                    {{ request()->is('perfil') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Gerir Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('perfil.moradas')}}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
                    {{ request()->is('paginas/perfil/moradas') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Moradas Adicionadas</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('perfilCartoes')}}" class="flex items-center gap-3 px-4 py-3 rounded-md transition-colors
                    {{ request()->is('paginas/perfil/cartões') ? 'bg-gray-200 text-primary font-semibold' : 'text-sidebar-foreground hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>Cartões Adicionados</span>
                    </a>
                </li>
            </ul>
        </nav>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <div class="p-4 mt-auto border-t border-gray-200">
                <button class="flex items-center gap-3 px-4 py-3 bg-red-50 border  border-red-200 hover:border-red-300 text-red-600 hover:text-red-700 rounded-md transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Sair</span>
                </button>
            </div>
        </form>
    </div>
</div>

