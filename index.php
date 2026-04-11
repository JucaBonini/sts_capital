<?php get_header(); ?>

<main class="pt-32 pb-20 max-w-screen-2xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Sidebar Esquerda: Centro de Inteligência -->
    <aside class="hidden lg:flex flex-col w-64 p-6 gap-4 bg-slate-100 dark:bg-slate-800/50 rounded-none h-fit sticky top-24 lg:col-span-3">
        <div class="mb-6">
            <div class="text-lg font-bold text-slate-900 dark:text-white">Centro de Inteligência</div>
            <div class="text-xs text-slate-500 uppercase tracking-widest font-label">Feed de Notícias</div>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/trending'); ?>">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="font-inter text-sm font-medium">Tendências</span>
            </a>
            <a class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-3" href="<?php echo home_url('/category/solar'); ?>">
                <span class="material-symbols-outlined">wb_sunny</span>
                <span class="font-inter text-sm font-medium">Tecnologia Solar</span>
            </a>
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/category/wind'); ?>">
                <span class="material-symbols-outlined">air</span>
                <span class="font-inter text-sm font-medium">Energia Eólica</span>
            </a>
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="<?php echo home_url('/category/policy'); ?>">
                <span class="material-symbols-outlined">policy</span>
                <span class="font-inter text-sm font-medium">Políticas Públicas</span>
            </a>
        </nav>
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
            <button class="w-full text-center bg-primary text-white py-3 rounded-lg font-bold text-sm">Participe da Rede</button>
        </div>
    </aside>

    <!-- Conteúdo Principal: Feed -->
    <section class="lg:col-span-6">
        <header class="mb-12">
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface mb-4">
                <?php if ( is_home() ) : ?>
                    Arquivo Editorial
                <?php else : ?>
                    <?php the_archive_title(); ?>
                <?php endif; ?>
            </h1>
            <p class="text-on-surface-variant font-label text-sm uppercase tracking-widest">Acompanhando a transição sustentável</p>
        </header>

        <div class="space-y-16">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="group">
                    <div class="flex items-center gap-3 mb-4">
                        <?php
                        $label = get_post_meta( get_the_ID(), '_sts_content_label', true ) ?: 'noticia';
                        echo '<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold font-label tracking-wider uppercase">' . esc_html(ucfirst($label)) . '</span>';
                        ?>
                        <span class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest">
                            <?php echo get_the_date(); ?>
                        </span>
                    </div>
                    
                    <h2 class="text-3xl font-headline font-bold tracking-tight leading-tight text-on-surface mb-6 group-hover:text-primary transition-colors">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="article-content">
                        <p class="text-lg font-medium leading-relaxed mb-6 text-on-surface opacity-90">
                            <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                        </p>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-widest group-hover:translate-x-1 transition-transform">
                        Ler Inteligência Completa
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </article>
            <?php endwhile; else : ?>
                <p>Nenhum artigo encontrado.</p>
            <?php endif; ?>
        </div>

        <div class="mt-16 py-8 border-t border-surface-container-high flex justify-center">
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
            <!-- Sidebar Widget: Top Intelligence -->
            <section>
                <h4 class="font-headline font-bold text-on-surface mb-6 uppercase tracking-wider text-xs border-b-2 border-primary-container pb-2 inline-block">Destaques</h4>
                <div class="space-y-8">
                    <?php
                    $popular = new WP_Query( array( 'posts_per_page' => 3, 'orderby' => 'rand' ) );
                    if ( $popular->have_posts() ) : while ( $popular->have_posts() ) : $popular->the_post(); ?>
                        <a class="group block" href="<?php the_permalink(); ?>">
                            <div class="aspect-video bg-surface-container rounded-lg mb-3 overflow-hidden">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500')); ?>
                                <?php endif; ?>
                            </div>
                            <span class="text-[10px] font-label font-bold text-primary uppercase tracking-widest"><?php echo get_the_date(); ?></span>
                            <h5 class="font-headline font-bold text-sm leading-snug group-hover:text-primary transition-colors mt-1">
                                <?php the_title(); ?>
                            </h5>
                        </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </section>

            <!-- Newsletter Card -->
            <div class="bg-surface-container p-8 rounded-xl ring-1 ring-inset ring-black/5 dark:ring-white/5">
                <span class="material-symbols-outlined text-primary mb-4">bolt</span>
                <h4 class="font-headline font-bold mb-2">Resumo Semanal</h4>
                <p class="text-sm text-on-surface-variant mb-6">Análises técnicas e mudanças no setor, entregues toda terça-feira.</p>
                <button class="w-full py-3 border border-primary text-primary font-bold rounded hover:bg-primary hover:text-white transition-all text-xs">Acesse Gratuitamente</button>
            </div>

            <!-- Espaço Publicitário -->
            <div class="w-full h-64 bg-surface-container-low flex items-center justify-center border border-dashed border-outline-variant rounded-xl group hover:bg-surface-container transition-colors">
                <span class="text-outline font-label text-[10px] tracking-widest uppercase opacity-60 [writing-mode:vertical-lr]">Publicidade</span>
            </div>
        </div>
    </aside>
</main>

<?php get_footer(); ?>
