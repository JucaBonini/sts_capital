<?php get_header(); ?>

<main class="pt-32 pb-20 max-w-screen-2xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Sidebar Esquerda -->
    <aside class="hidden lg:flex flex-col w-64 p-6 gap-4 bg-slate-100 dark:bg-slate-800/50 rounded-none h-fit sticky top-24 lg:col-span-3">
        <div class="mb-6">
            <div class="text-lg font-bold text-slate-900 dark:text-white">Busca Técnica</div>
            <div class="text-xs text-slate-500 uppercase tracking-widest font-label"><?php printf( 'Resultados para: %s', get_search_query() ); ?></div>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/'); ?>">
                <span class="material-symbols-outlined">home</span>
                <span class="font-inter text-sm font-medium">Voltar ao Início</span>
            </a>
        </nav>
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
            <span class="text-xs text-slate-400">Total de <?php echo $wp_query->found_posts; ?> resultados.</span>
        </div>
    </aside>

    <!-- Conteúdo Principal -->
    <section class="lg:col-span-6">
        <header class="mb-16">
            <span class="text-primary font-label text-xs uppercase tracking-widest mb-2 block font-bold">Motor de Busca</span>
            <h1 class="text-4xl md:text-5xl font-headline font-black tracking-tighter text-on-surface mb-8">
                <?php printf( 'Pesquisa: "%s"', get_search_query() ); ?>
            </h1>
            
            <!-- Barra de Busca Customizada -->
            <form role="search" method="get" class="flex gap-2" action="<?php echo home_url( '/' ); ?>">
                <input type="search" class="flex-1 bg-slate-100 dark:bg-slate-800 border-none rounded-lg px-6 py-4 text-on-surface focus:ring-2 focus:ring-primary" placeholder="Nova pesquisa..." value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="bg-primary text-white px-8 rounded-lg font-bold">Buscar</button>
            </form>
        </header>

        <div class="space-y-12">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="group">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-primary text-[10px] font-black tracking-widest uppercase font-label">Resultado Matriz</span>
                        <span class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest"><?php echo get_the_date(); ?></span>
                    </div>
                    <h2 class="text-2xl font-headline font-bold tracking-tight leading-snug group-hover:text-primary transition-colors mb-3">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="text-sm text-on-surface-variant leading-relaxed mb-4 opacity-80">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="text-primary font-bold text-xs uppercase tracking-widest flex items-center gap-2">Ver Detalhes <span class="material-symbols-outlined text-[14px]">arrow_forward</span></a>
                </article>
            <?php endwhile; else : ?>
                <div class="py-20 text-center bg-slate-50 dark:bg-slate-900 rounded-3xl">
                    <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-700 mb-6">docs</span>
                    <h3 class="text-xl font-bold mb-2">Nenhum dado encontrado</h3>
                    <p class="text-slate-500">Tente buscar por termos mais genéricos como "solar", "energia" ou "perovskita".</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <div class="mt-16 py-8 border-t border-slate-100 dark:border-slate-800 flex justify-center">
            <?php the_posts_pagination(); ?>
        </div>
    </section>

    <!-- Sidebar Direita -->
    <aside class="lg:col-span-3">
        <div class="sticky top-24 flex flex-col gap-12">
            <div class="bg-primary p-8 rounded-3xl text-white shadow-2xl">
                 <h4 class="font-headline font-bold mb-4">Assine a News</h4>
                 <p class="text-xs opacity-80 leading-relaxed mb-6">Não encontrou o que buscava? Receba nossa inteligência semanal.</p>
                 <button class="w-full py-3 bg-white text-primary font-bold rounded-lg text-xs uppercase">Assinar</button>
            </div>
            
            <div class="w-full h-80 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center border border-dashed border-slate-300 dark:border-slate-700">
                <span class="text-[10px] text-slate-400 uppercase tracking-widest">Publicidade Lateral</span>
            </div>
        </div>
    </aside>
</main>

<?php get_footer(); ?>
