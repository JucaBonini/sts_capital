<?php get_header(); ?>

<!-- Premium Top Billboard (Dinâmico) -->
<div class="pt-32 max-w-screen-2xl mx-auto px-8">
    <?php sts_display_ad('top_billboard'); ?>
</div>

<main class="pt-12 pb-20 max-w-screen-2xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Sidebar Esquerda: Navegação -->
    <aside class="hidden lg:flex flex-col w-64 p-6 gap-4 bg-slate-100 dark:bg-slate-800/50 rounded-none h-fit sticky top-24 lg:col-span-3">
        <div class="mb-6">
            <div class="text-lg font-bold text-slate-900 dark:text-white">Centro de Inteligência</div>
            <div class="text-xs text-slate-500 uppercase tracking-widest font-label">Navegação de Categoria</div>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/'); ?>">
                <span class="material-symbols-outlined">home</span>
                <span class="font-inter text-sm font-medium">Voltar ao Início</span>
            </a>
            <a class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-3" href="#">
                <span class="material-symbols-outlined">wb_sunny</span>
                <span class="font-inter text-sm font-medium">Lendo Agora</span>
            </a>
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/trending'); ?>">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="font-inter text-sm font-medium">Tendências</span>
            </a>
        </nav>
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
            <button class="w-full text-center bg-primary text-white py-3 rounded-lg font-bold text-sm">Participe da Rede</button>
        </div>
    </aside>

    <!-- Conteúdo Principal: Feed do Arquivo -->
    <section class="lg:col-span-6">
        <header class="mb-16 border-l-4 border-emerald-500 pl-8">
            <!-- Breadcrumb Visível -->
            <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-6">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                <span class="text-slate-300 dark:text-slate-600 uppercase">Arquivo</span>
            </nav>
            <span class="text-emerald-600 dark:text-emerald-400 font-label text-xs uppercase tracking-[0.2em] mb-2 block font-bold">Arquivo de Inteligência</span>
            <h1 class="text-4xl md:text-5xl font-headline font-black tracking-tighter text-on-surface mb-4 leading-none">
                <?php the_archive_title(); ?>
            </h1>
            <?php if ( get_the_archive_description() ) : ?>
                <div class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed max-w-xl">
                    <?php the_archive_description(); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="grid grid-cols-1 gap-16">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="group flex flex-col md:flex-row gap-8 items-start">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="w-full md:w-48 aspect-square rounded-xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-500 flex-shrink-0">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700')); ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="w-full md:w-48 aspect-video bg-emerald-50 dark:bg-emerald-900/10 rounded-xl flex items-center justify-center flex-shrink-0">
                             <span class="material-symbols-outlined text-emerald-200 dark:text-emerald-800 text-4xl">wb_sunny</span>
                        </div>
                    <?php endif; ?>

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <?php
                            $label = get_post_meta( get_the_ID(), '_sts_content_label', true ) ?: 'ANÁLISE';
                            echo '<span class="text-primary text-[10px] font-black tracking-[0.15em] uppercase font-label">' . esc_html($label) . '</span>';
                            ?>
                            <span class="w-1 h-1 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                            <span class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest">
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>
                        
                        <h2 class="text-2xl font-headline font-bold tracking-tight leading-snug text-on-surface mb-4 group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p class="text-sm text-on-surface-variant leading-relaxed mb-6 opacity-80">
                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-widest hover:gap-4 transition-all group-hover:text-emerald-600">
                            Acessar Inteligência
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </article>
            <?php endwhile; else : ?>
                <div class="py-20 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-200 dark:text-slate-800 mb-4">search_off</span>
                    <p class="text-slate-500">Nenhum artigo encontrado nesta categoria.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <div class="mt-20 py-10 border-t border-slate-100 dark:border-slate-800 flex justify-center">
            <?php the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
            ) ); ?>
        </div>
    </section>

    <!-- Sidebar Direita -->
    <aside class="lg:col-span-3">
        <div class="sticky top-24 flex flex-col gap-12">
            <!-- Sidebar Noble Ad (Dinâmico) -->
            <?php sts_display_ad('sidebar_top_ad', '
            <div class="bg-slate-900 border border-primary/20 p-8 rounded-3xl text-white shadow-2xl overflow-hidden relative group">
                <span class="text-[10px] text-primary font-black uppercase tracking-widest block mb-4">Parceiro Estratégico</span>
                <div class="aspect-square bg-slate-800 rounded-2xl border border-slate-700 flex items-center justify-center text-slate-500 text-center text-xs p-6 group-hover:border-primary/50 transition-colors">
                    Espaço para Banner Lateral<br>(Sidebar Top)
                </div>
                <!-- Micro-animação de luz no hover -->
                <div class="absolute -right-20 -bottom-20 w-48 h-48 bg-primary opacity-20 rounded-full blur-[60px] group-hover:bg-primary/40 transition-all duration-700"></div>
            </div>'); ?>

            <!-- Posts Populares -->
            <section>
                <h4 class="font-headline font-bold text-on-surface mb-6 uppercase tracking-[0.1em] text-[11px] border-b-2 border-primary-container pb-2 inline-block">Análises em Destaque</h4>
                <div class="space-y-8">
                    <?php
                    $popular = new WP_Query( array( 'posts_per_page' => 3, 'orderby' => 'rand' ) );
                    if ( $popular->have_posts() ) : while ( $popular->have_posts() ) : $popular->the_post(); ?>
                        <a class="group block" href="<?php the_permalink(); ?>">
                            <div class="flex gap-4 items-start">
                                <span class="text-2xl font-black text-slate-200 dark:text-slate-800 tabular-nums">0<?php echo $popular->current_post + 1; ?></span>
                                <div>
                                    <h5 class="font-headline font-bold text-sm leading-tight group-hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </h5>
                                    <span class="text-[9px] font-label font-bold text-on-surface-variant uppercase tracking-widest mt-1 block"><?php echo get_the_date(); ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </section>

            <!-- Newsletter -->
            <div class="bg-slate-900 p-8 rounded-2xl text-white relative overflow-hidden shadow-2xl">
                 <span class="material-symbols-outlined text-primary mb-4 text-3xl">bolt</span>
                <h4 class="font-headline font-bold mb-2">Resumo Semanal</h4>
                <p class="text-xs text-slate-400 leading-relaxed mb-6">Mergulhos técnicos entregues toda terça-feira direto no seu e-mail.</p>
                <button class="w-full py-3 bg-primary text-white font-bold rounded hover:opacity-90 transition-all text-xs uppercase tracking-widest">Assine Grátis</button>
                <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-primary/20 rounded-full blur-2xl"></div>
            </div>
        </div>
    </aside>
</main>

<?php get_footer(); ?>
