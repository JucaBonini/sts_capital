<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <?php wp_head(); ?>
    <style>
        :root {
            --primary: #10b981;
            --primary-container: #064e3b;
        }
        
        /* Typography Master System */
        .article-content h2, .prose h2 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-top: 2.5rem; margin-bottom: 1.25rem; line-height: 1.2; letter-spacing: -0.02em; font-family: 'Outfit', sans-serif; }
        .article-content h3, .prose h3 { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-top: 2rem; margin-bottom: 1rem; line-height: 1.3; font-family: 'Outfit', sans-serif; }
        .article-content h4, .prose h4 { font-size: 1.25rem; font-weight: 700; color: #334155; margin-top: 1.5rem; margin-bottom: 0.75rem; }
        
        .article-content p, .prose p { margin-bottom: 1.5rem; line-height: 1.8; color: #475569; font-size: 1.125rem; }
        
        .article-content ul, .prose ul { list-style-type: none; margin-bottom: 1.5rem; padding-left: 0.5rem; }
        .article-content ul li, .prose ul li { position: relative; padding-left: 1.5rem; margin-bottom: 0.75rem; color: #475569; line-height: 1.7; }
        .article-content ul li::before, .prose ul li::before { content: ""; position: absolute; left: 0; top: 0.7rem; width: 0.5rem; height: 0.2rem; background: var(--primary); border-radius: 2px; }
        
        .article-content ol, .prose ol { list-style-type: decimal; margin-bottom: 1.5rem; padding-left: 1.5rem; color: #475569; }
        .article-content ol li, .prose ol li { margin-bottom: 0.75rem; padding-left: 0.5rem; }
        
        .article-content blockquote, .prose blockquote { border-left: 4px solid var(--primary); padding: 1.5rem 2rem; background: #f8fafc; margin: 2rem 0; border-radius: 0 1rem 1rem 0; font-style: italic; color: #1e293b; }
        
        .article-content strong, .prose strong { color: #0f172a; font-weight: 700; }
        
        .article-content img, .prose img { border-radius: 1rem; margin: 2rem 0; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1); }
        
        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .article-content h2, .prose h2, .article-content h3, .prose h3, .article-content h4, .prose h4, .article-content strong, .prose strong { color: #f8fafc; }
            .article-content p, .prose p, .article-content ul li, .prose ul li, .article-content ol li, .prose ol li { color: #94a3b8; }
            .article-content blockquote, .prose blockquote { background: #0f172a; color: #e2e8f0; }
        }
    </style>
</head>

<body <?php body_class('bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container'); ?>>
<?php wp_body_open(); ?>

<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="flex justify-between items-center px-8 py-4 max-w-screen-2xl mx-auto gap-8">
        <!-- LADO ESQUERDO: EDITORIAL (LEITOR) -->
        <div class="flex items-center gap-10">
            <div class="text-2xl font-black tracking-tighter text-slate-900 dark:text-white shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="h-10 w-auto flex items-center">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                <?php endif; ?>
            </div>

            <nav class="hidden xl:flex gap-8 items-center border-l border-slate-200 dark:border-slate-800 pl-10">
                <ul class="flex gap-8 list-none p-0 m-0">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false,
                        'walker'         => new STS_Tailwind_Walker(),
                    ) );
                    ?>
                </ul>
            </nav>
        </div>

        <!-- LADO DIREITO: NEGÓCIOS (SAAS) -->
        <div class="flex items-center gap-4 lg:gap-6 shrink-0">
            <div class="hidden sm:block text-slate-600 dark:text-slate-400 cursor-pointer hover:text-emerald-500 transition-colors">
                <span class="material-symbols-outlined align-middle">search</span>
            </div>

            <div class="hidden md:flex items-center gap-6 border-l border-slate-200 dark:border-slate-800 pl-6">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo home_url('/dashboard-instalador'); ?>" class="text-slate-600 dark:text-slate-400 font-black uppercase tracking-widest text-[10px] hover:text-primary transition-colors">Meu Dashboard</a>
                <?php else : ?>
                    <a href="<?php echo home_url('/login-instalador'); ?>" class="text-slate-600 dark:text-slate-400 font-black uppercase tracking-widest text-[10px] hover:text-primary transition-colors">Login</a>
                <?php endif; ?>

                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="text-[9px] font-black uppercase text-slate-400 hover:text-red-500 transition-colors">Sair</a>
                <?php else : ?>
                    <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-3 text-white font-black uppercase tracking-widest text-[10px] rounded-xl hover:shadow-2xl hover:shadow-emerald-500/20 transition-all duration-300 transform active:scale-95 border border-white/10">
                        <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                        Divulgar Empresa
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Toggle -->
            <button id="mobile-menu-toggle" class="lg:hidden p-2 text-slate-900 dark:text-white focus:outline-none">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </div>
    </div>

    <!-- Reading Progress Bar (Only for Single Posts) -->
    <?php if ( is_single() ) : ?>
    <div id="scroll-progress" class="h-[2px] bg-primary w-0 transition-all duration-100 ease-out"></div>
    <script>
        window.addEventListener('scroll', () => {
            const windownScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (windownScroll / height) * 100;
            document.getElementById('scroll-progress').style.width = scrolled + '%';
        });
    </script>
    <?php endif; ?>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 z-[60] bg-white dark:bg-slate-950 hidden flex-col transition-all duration-300 opacity-0 -translate-y-4">
    <div class="flex justify-between items-center px-8 py-4 border-b border-slate-100 dark:border-slate-800">
        <div class="text-xl font-black tracking-tighter text-slate-900 dark:text-white"><?php bloginfo('name'); ?></div>
        <button id="mobile-menu-close" onclick="document.getElementById('mobile-menu-toggle').click()" class="p-2 text-slate-900 dark:text-white">
            <span class="material-symbols-outlined text-3xl">close</span>
        </button>
    </div>
    <nav class="flex-grow overflow-y-auto px-8 py-10">
        <div class="mb-10 lg:hidden">
            <?php if ( has_custom_logo() ) : ?>
                <div class="h-8 w-auto">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
        </div>
        <ul class="flex flex-col gap-6 list-none p-0 m-0">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-1',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => false,
                'walker'         => new STS_Tailwind_Walker(),
            ) );
            ?>
        </ul>
        <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 space-y-4">
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo home_url('/dashboard-instalador'); ?>" class="block w-full text-center bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 py-4 rounded-xl font-black uppercase tracking-widest text-xs">Acessar Meu Painel</a>
            <?php else : ?>
                <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="block w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs shadow-lg">Divulgar Minha Empresa</a>
            <?php endif; ?>
            <a href="<?php echo home_url('/contato'); ?>" class="block w-full text-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 py-4 rounded-xl font-bold uppercase tracking-widest text-xs">Fale Conosco</a>
        </div>
    </nav>
</div>

<script>
    // Mobile Menu Logic
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const closeBtn = document.getElementById('mobile-menu-close');
    const menu = document.getElementById('mobile-menu');

    function toggleMenu() {
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.remove('opacity-0', '-translate-y-4');
                menu.classList.add('opacity-100', 'translate-y-0');
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            menu.classList.add('opacity-0', '-translate-y-4');
            menu.classList.remove('opacity-100', 'translate-y-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
        }
    }

    toggleBtn.addEventListener('click', toggleMenu);
    if(closeBtn) closeBtn.addEventListener('click', toggleMenu);
</script>
