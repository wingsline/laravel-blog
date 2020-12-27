<nav class="w-full">
    {{
        \Spatie\Menu\Laravel\Facades\Menu::new()
            ->addItemClass('block text-sm text-gray-800 px-2 py-1')
            ->add(\Spatie\Menu\Laravel\Html::raw('<h3>Admin</h3>')->addParentClass('px-2 text-gray-500 uppercase tracking-wide font-semibold text-xs mt-6 pb-1'))
            ->route('admin.dashboard', 'Dashboard')
            ->setActiveFromRequest(config('blog.adminprefix'))
    }}
</nav>
