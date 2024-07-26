<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-32 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{route('admin.user.list')}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->routeIs('admin.user.list') ? "bg-gray-100 dark:bg-gray-700" : ""}}">
                    Clientes
                </a>
            </li>
            <li>
                <a href="{{route('admin.order.list')}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->routeIs('admin.order.list') ? "bg-gray-100 dark:bg-gray-700" : ""}}">
                    Pedidos
                </a>
            </li>
            <li>
                <a href="{{route('admin.card.imgs')}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->routeIs('admin.card.imgs') ? "bg-gray-100 dark:bg-gray-700" : ""}}">
                    Imagens
                </a>
            </li>
            <li>
                <a href="{{route('admin.setting')}}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->routeIs('admin.setting') ? "bg-gray-100 dark:bg-gray-700" : ""}}">
                    Configurações
                </a>
            </li>
        </ul>
    </div>
</aside>
