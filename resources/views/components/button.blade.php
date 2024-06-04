<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-1 lg:px-4  py-1 lg:py-2 bg-blue-6 border border-transparent rounded-md font-body  text-[10px] xl:text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 transition ease-in-out duration-150 shadow-sm shadow-gray-400']) }}>
    {{ $slot }}
</button>
