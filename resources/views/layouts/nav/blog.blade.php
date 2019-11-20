<nav class="mt-8 w-full">
    {{
        \Spatie\Menu\Laravel\Facades\Menu::new()
            ->addItemClass('py-1 block text-sm text-gray-800  px-2 py-1')
            ->add(\Spatie\Menu\Laravel\Html::raw('<h3>Blog</h3>')->addParentClass('px-2 text-gray-500 uppercase tracking-wide font-semibold text-xs pb-1'))
            ->route('admin.posts.index', 'Posts')
            ->setActiveFromRequest(config('blog.prefix'))
    }}
</nav>
