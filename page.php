<?php get_header(); ?>

<main class="pt-40 pb-24 min-h-[70vh]">
    <div class="max-w-screen-md mx-auto px-8">
        
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <header class="mb-12 border-l-4 border-primary pl-8">
                <h1 class="text-4xl md:text-6xl font-headline font-black tracking-tighter text-on-surface leading-tight">
                    <?php the_title(); ?>
                </h1>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="mb-12 rounded-2xl overflow-hidden shadow-xl aspect-video w-full">
                    <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
                </div>
            <?php endif; ?>

            <article class="prose prose-slate dark:prose-invert max-w-none text-on-surface-variant leading-relaxed">
                <?php the_content(); ?>
            </article>

            <!-- Metadata de Atualização (Sinal de E-E-A-T) -->
            <footer class="mt-20 pt-8 border-t border-slate-100 dark:border-slate-800 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                Última atualização em: <?php the_modified_date(); ?> — Capital Consciente Intelligence
            </footer>

        <?php endwhile; endif; ?>
    </div>
</main>

<?php get_footer(); ?>
