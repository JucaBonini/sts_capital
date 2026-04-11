<?php get_header(); ?>

<div class="pt-32 max-w-screen-2xl mx-auto px-8">
    <!-- Billboard Superior (Dinâmico) -->
    <?php sts_display_ad('top_billboard'); ?>
</div>

<main class="max-w-screen-2xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 pb-20">
    
    <!-- Lado Esquerdo: Conteúdo do Artigo -->
    <article class="lg:col-span-8">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <header class="mb-12">
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-primary font-label text-xs font-black uppercase tracking-[0.2em] border-l-2 border-primary pl-3">
                        <?php 
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->name ); }
                        ?>
                    </span>
                    <span class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full">
                        <?php echo get_the_date(); ?>
                    </span>
                </div>

                <!-- Breadcrumb Visível -->
                <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">
                    <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Home</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <?php if ( ! empty( $categories ) ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="hover:text-primary transition-colors"><?php echo esc_html( $categories[0]->name ); ?></a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <?php endif; ?>
                    <span class="text-slate-300 dark:text-slate-600 truncate max-w-[150px]">Lendo Agora</span>
                </nav>

                <h1 class="text-4xl md:text-6xl font-headline font-extrabold tracking-tight leading-tight text-on-surface mb-8">
                    <?php the_title(); ?>
                </h1>

                <!-- Autor e E-E-A-T -->
                <div class="flex items-center gap-6 py-8 border-y border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200">
                        <?php echo get_avatar( get_the_author_meta('ID'), 96 ); ?>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface m-0 p-0 leading-none"><?php the_author(); ?></p>
                        <p class="text-[10px] text-on-surface-variant m-0 p-0 mt-1 uppercase tracking-widest font-bold"><?php echo get_the_author_meta('expertise') ?: 'Analista de Pesquisa'; ?></p>
                        <div class="flex gap-2 mt-2">
                            <?php if ( get_the_author_meta('linkedin') ) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('linkedin')); ?>" class="text-slate-400 hover:text-primary transition-colors"><span class="material-symbols-outlined text-[14px]">share</span></a>
                            <?php endif; ?>
                            <?php if ( get_the_author_meta('twitter') ) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('twitter')); ?>" class="text-slate-400 hover:text-primary transition-colors"><span class="material-symbols-outlined text-[14px]">alternate_email</span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="ml-auto flex gap-2">
                        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors"><span class="material-symbols-outlined">share</span></button>
                        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors"><span class="material-symbols-outlined">bookmark</span></button>
                    </div>
                </div>
            </header>

            <!-- Imagem de Destaque -->
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden mb-12 shadow-2xl">
                <?php the_post_thumbnail('google-discover', array('class' => 'w-full h-full object-cover')); ?>
                <div class="absolute bottom-4 left-4 glass-panel px-4 py-2 rounded-lg text-white">
                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-80"><?php echo get_post(get_post_thumbnail_id())->post_excerpt ?: 'Imagem de Análise Editorial'; ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Banner Topo do Artigo (CONTROLE DINÂMICO) -->
            <?php sts_display_ad('article_top_ad', '
            <div class="w-full h-24 bg-slate-50 dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 rounded-xl mb-12 flex items-center justify-center opacity-60">
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Publicidade Interior - Topo Artigo</span>
            </div>'); ?>

            <!-- Conteúdo -->
            <div class="article-content prose prose-slate dark:prose-invert max-w-none">
                <?php echo sts_capital_get_toc(); ?>
                <?php the_content(); ?>
            </div>

            <!-- Banner Final do Artigo (CONTROLE DINÂMICO) -->
            <?php sts_display_ad('article_bottom_ad', '
            <div class="w-full h-32 bg-slate-50 dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 rounded-xl my-16 flex items-center justify-center opacity-60">
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Publicidade Interior - Final Artigo</span>
            </div>'); ?>

            <!-- Rodapé do Artigo -->
            <footer class="mt-20">
                <div class="flex flex-wrap gap-2 mb-12">
                    <?php the_tags('<span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mr-2">Tags:</span> #', ' #', ''); ?>
                </div>

                <!-- Call to Action (Newsletter Self-Hosted) -->
                <section class="bg-primary p-12 rounded-3xl text-white relative overflow-hidden group mt-16">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black mb-4">Inscreva-se na nossa Inteligência.</h3>
                        <p class="opacity-80 max-w-md mb-8">Receba os melhores insights sobre capitalismo consciente e tecnologia solar diretamente no seu e-mail.</p>
                        
                        <?php if ( isset($_GET['subscribe']) ) : ?>
                            <div class="mb-6 p-4 rounded-xl bg-white/10 text-white font-bold text-sm">
                                <?php echo $_GET['subscribe'] === 'success' ? '✓ Inscrição confirmada.' : '✕ Erro no e-mail.'; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="flex flex-col sm:flex-row gap-2">
                            <input type="hidden" name="action" value="sts_newsletter">
                            <?php wp_nonce_field('sts_newsletter_action', 'sts_newsletter_nonce'); ?>
                            <input name="newsletter_email" type="email" placeholder="Seu melhor e-mail" class="flex-1 px-6 py-4 rounded-xl bg-white/10 border-none text-white placeholder-white/40 focus:ring-2 focus:ring-white" required>
                            <button type="submit" class="bg-white text-primary px-8 py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-slate-100 transition-colors">Acessar</button>
                        </form>
                    </div>
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-[100px]"></div>
                </section>
            </footer>

        <?php endwhile; endif; ?>
    </article>

    <!-- Lado Direito: Sidebar -->
    <aside class="lg:col-span-4">
        <div class="sticky top-24 flex flex-col gap-12 pl-0 lg:pl-10">
            
            <!-- Banner Sidebar Topo (CONTROLE DINÂMICO) -->
            <?php sts_display_ad('sidebar_top_ad', '
            <div class="w-full h-[400px] bg-slate-50 dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 rounded-3xl flex items-center justify-center opacity-60">
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 [writing-mode:vertical-lr]">Sidebar Prime Ad</span>
            </div>'); ?>

            <!-- Posts Relacionados / Recentes -->
            <section>
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-on-surface mb-8 border-b-2 border-primary-container pb-2 inline-block">Radar do Setor</h4>
                <div class="space-y-8">
                    <?php
                    $side_query = new WP_Query( array( 'posts_per_page' => 4, 'post__not_in' => array( get_the_ID() ) ) );
                    if ( $side_query->have_posts() ) : while ( $side_query->have_posts() ) : $side_query->the_post();
                    ?>
                    <article class="group">
                        <span class="text-[9px] font-bold text-primary uppercase tracking-widest block mb-2"><?php echo get_the_date(); ?></span>
                        <h5 class="font-headline font-bold leading-tight group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                    </article>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </section>

            <!-- Banner Sidebar Rodapé (CONTROLE DINÂMICO) -->
            <?php sts_display_ad('sidebar_bottom_ad', '
            <div class="w-full h-80 bg-slate-50 dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 rounded-3xl flex items-center justify-center opacity-60">
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Sidebar Footer Ad</span>
            </div>'); ?>

        </div>
    </aside>

</main>

<?php get_footer(); ?>
