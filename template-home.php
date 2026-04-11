<?php
/**
 * Template Name: Tech Portal Luxe
 */

get_header(); ?>

<!-- Premium Top Billboard (Espaço Dinâmico) -->
<div class="pt-32 max-w-screen-2xl mx-auto px-8">
    <?php sts_display_ad('top_billboard', '
    <div class="w-full h-24 sm:h-32 bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-dashed border-slate-300 dark:border-slate-700 rounded-xl group hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
        <div class="text-center">
            <span class="text-slate-400 font-label text-[10px] tracking-widest uppercase block mb-1">Publicidade Premium - Top Billboard</span>
            <div class="w-24 h-1 bg-primary/20 rounded-full mx-auto"></div>
        </div>
    </div>'); ?>
</div>

<main class="pt-12 pb-20 max-w-screen-2xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <!-- Sidebar Esquerda -->
    <aside class="hidden lg:flex flex-col w-64 p-6 gap-4 bg-slate-100 dark:bg-slate-800/50 rounded-none h-fit sticky top-24 lg:col-span-3">
        <div class="mb-6">
            <div class="text-lg font-bold text-slate-900 dark:text-white">Centro de Inteligência</div>
            <div class="text-xs text-slate-500 uppercase tracking-widest font-label">Experiência do Portal</div>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-3" href="#">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-inter text-sm font-medium">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="#latest">
                <span class="material-symbols-outlined">newspaper</span>
                <span class="font-inter text-sm font-medium">Últimas Notícias</span>
            </a>
            <a class="flex items-center gap-3 text-slate-500 dark:text-slate-400 p-3 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all hover:translate-x-1" href="#">
                <span class="material-symbols-outlined">topic</span>
                <span class="font-inter text-sm font-medium">Análises Profundas</span>
            </a>
        </nav>
        
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
            <button class="w-full text-center bg-primary text-white py-3 rounded-lg font-bold text-sm">Participe da Rede</button>
        </div>
    </aside>

    <!-- Conteúdo Principal -->
    <section class="lg:col-span-6">
        <!-- Post em Destaque -->
        <?php
        $top_query = new WP_Query( array( 'posts_per_page' => 1 ) );
        if ( $top_query->have_posts() ) : $top_query->the_post();
        ?>
        <article class="mb-16">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-bold font-label tracking-wider uppercase">Destaque Principal</span>
                <span class="text-on-surface-variant font-label text-xs uppercase tracking-widest"><?php echo get_the_date(); ?></span>
            </div>
            <h1 class="text-4xl md:text-6xl font-headline font-extrabold tracking-tight leading-tight text-on-surface mb-8">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h1>
            
            <div class="relative w-full aspect-video rounded-xl overflow-hidden mb-8 shadow-2xl group">
                <?php the_post_thumbnail('google-discover', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105')); ?>
                <div class="absolute bottom-4 left-4 glass-panel px-4 py-2 rounded-lg">
                    <p class="text-xs font-medium text-on-surface">Relatório de Inteligência Primária</p>
                </div>
            </div>

            <p class="text-xl font-medium leading-relaxed mb-8 text-on-surface opacity-90">
                <?php echo wp_trim_words(get_the_excerpt(), 35); ?>
            </p>
            
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-primary font-bold text-sm uppercase tracking-widest hover:translate-x-1 transition-transform">
                Ler Insight Completo
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </article>
        <?php wp_reset_postdata(); endif; ?>

        <!-- Noble In-Feed Ad Space (Dinâmico) -->
        <?php sts_display_ad('in_feed_ad', '
        <div class="mb-16 p-8 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 flex flex-col md:flex-row items-center gap-6 group hover:shadow-lg transition-all">
            <div class="w-full md:w-1/3 aspect-video bg-emerald-100 dark:bg-emerald-800 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-widest">
                Espaço Nobre 01
            </div>
            <div class="flex-1">
                <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-widest mb-2 block">Conteúdo Patrocinado</span>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2 leading-tight">Sua marca em destaque no maior portal de energia solar.</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">Alcance decisores e profissionais do setor fotovoltaico de forma nativa e premium.</p>
            </div>
        </div>'); ?>

        <!-- Últimas Notícias (Grid) -->
        <div id="latest" class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-12 border-t border-surface-container-high">
            <?php
            $feed_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 1 ) );
            if ( $feed_query->have_posts() ) : while ( $feed_query->have_posts() ) : $feed_query->the_post();
            ?>
            <article class="group">
                <div class="aspect-video bg-surface-container rounded-xl mb-4 overflow-hidden relative shadow-md group-hover:shadow-lg transition-all">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110')); ?>
                    <?php endif; ?>
                    <div class="absolute top-2 left-2">
                        <span class="bg-white/90 backdrop-blur-sm text-primary px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest shadow-sm">Análise</span>
                    </div>
                </div>
                <span class="text-[10px] font-label font-bold text-on-surface-variant uppercase tracking-widest"><?php echo get_the_date(); ?></span>
                <h3 class="font-headline font-bold text-lg leading-tight group-hover:text-primary transition-colors mt-2 mb-3">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p class="text-sm text-on-surface-variant line-clamp-2"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            </article>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>

        <!-- Hub de Negócios: Instaladores em Destaque -->
        <section class="mt-20 pt-12 border-t border-surface-container-high">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-label text-xs font-black uppercase tracking-[0.3em]">Business Intelligence</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-headline font-black text-on-surface leading-tight">
                        Hub de <span class="text-primary">Instaladores Solares.</span>
                    </h2>
                    <p class="text-on-surface-variant mt-4 text-sm leading-relaxed">
                        Conecte-se com as melhores empresas de engenharia e instalação fotovoltaica verificadas pelo nosso time técnico.
                    </p>
                </div>
                <a href="<?php echo get_post_type_archive_link('instalador'); ?>" class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-on-surface hover:text-primary transition-colors">
                    Explorar Diretório Completo
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-2 transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $instaladores_query = new WP_Query( array( 
                    'post_type' => 'instalador',
                    'posts_per_page' => 4,
                    'post_status' => 'publish'
                ) );

                if ( $instaladores_query->have_posts() ) : 
                    while ( $instaladores_query->have_posts() ) : $instaladores_query->the_post(); 
                        $location = get_post_meta(get_the_ID(), '_sts_location_raw', true);
                ?>
                <article class="bg-surface-container-low border border-outline-variant/30 rounded-2xl p-6 hover:shadow-xl hover:border-primary/20 transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-primary/5 rounded-full blur-xl group-hover:bg-primary/10 transition-all"></div>
                    
                    <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-xl mb-4 overflow-hidden flex items-center justify-center p-2 shadow-sm border border-outline-variant/20">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-contain')); ?>
                        <?php else : ?>
                            <span class="material-symbols-outlined text-slate-300">image</span>
                        <?php endif; ?>
                    </div>

                    <h4 class="font-headline font-bold text-sm text-on-surface mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    
                    <div class="flex items-center gap-2 text-[10px] text-on-surface-variant font-medium mb-6">
                        <span class="material-symbols-outlined text-[14px] text-primary">location_on</span>
                        <?php echo $location ?: 'Brasil'; ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center justify-center w-full py-3 bg-white dark:bg-slate-800 border border-outline-variant/50 rounded-lg text-[9px] font-black uppercase tracking-tighter hover:bg-primary hover:text-white hover:border-primary transition-all">
                        Ver Perfil
                    </a>
                </article>
                <?php 
                    endwhile; 
                    wp_reset_postdata(); 
                else : 
                    // Fallback placeholder cards if no installers yet
                    for($i=1; $i<=4; $i++) :
                ?>
                <div class="bg-surface-container-low border border-dashed border-outline-variant/50 rounded-2xl p-6 flex flex-col items-center justify-center text-center opacity-60">
                    <span class="material-symbols-outlined text-3xl text-slate-300 mb-2">engineering</span>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-tight">Espaço para<br>Instalador Parceiro</p>
                </div>
                <?php 
                    endfor;
                endif; 
                ?>
            </div>
        </section>

        <!-- Call to Action (Newsletter Self-Hosted) -->
        <section class="mt-20 bg-inverse-surface rounded-2xl p-10 relative overflow-hidden text-inverse-on-surface">
            <div class="relative z-10">
                <h2 class="text-white mt-0 mb-4 text-3xl">Inteligência do Portal</h2>
                <p class="text-inverse-on-surface opacity-80 mb-8 max-w-sm">Junte-se à rede de elite de profissionais e tomadores de decisão do setor solar.</p>
                
                <?php if ( isset($_GET['subscribe']) ) : ?>
                    <div class="mb-6 p-4 rounded-lg bg-white/10 text-white font-bold text-sm">
                        <?php echo $_GET['subscribe'] === 'success' ? '✓ Inscrição confirmada. Bem-vindo!' : '✕ E-mail inválido. Tente novamente.'; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="flex flex-col sm:flex-row gap-4">
                    <input type="hidden" name="action" value="sts_newsletter">
                    <?php wp_nonce_field('sts_newsletter_action', 'sts_newsletter_nonce'); ?>
                    <input name="newsletter_email" class="bg-surface-container-highest/10 border-none rounded-xl px-6 py-4 flex-grow focus:ring-2 focus:ring-primary text-white placeholder-white/40" placeholder="Seu melhor e-mail" type="email" required/>
                    <button type="submit" class="bg-emerald-500 text-slate-900 px-8 py-4 rounded-xl font-bold hover:opacity-90 transition-all">Receber Atualizações</button>
                </form>
            </div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary opacity-10 rounded-full blur-[100px]"></div>
        </section>
    </section>

    <!-- Right Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-24 flex flex-col gap-12">
            <!-- Sidebar Noble Ad (Dinâmico) -->
            <?php sts_display_ad('sidebar_top_ad', '
            <div class="bg-slate-900 dark:bg-black p-6 rounded-2xl border border-primary/20 shadow-xl group overflow-hidden relative">
                <span class="text-[9px] text-primary font-black uppercase tracking-widest block mb-4">Destaque Exclusivo</span>
                <div class="aspect-[4/5] bg-slate-800 dark:bg-slate-900 rounded-lg flex items-center justify-center text-slate-500 text-xs text-center p-6 border border-slate-700 group-hover:border-primary/50 transition-colors">
                    Espaço Nobre Vertical<br>(Sidebar Top)
                </div>
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary/20 rounded-full blur-[40px] group-hover:bg-primary/40 transition-all"></div>
            </div>'); ?>

            <!-- Posts da Indústria -->
            <section>
                <h4 class="font-headline font-bold text-on-surface mb-6 uppercase tracking-wider text-xs border-b-2 border-primary-container pb-2 inline-block">Foco na Indústria</h4>
                <div class="space-y-8">
                    <?php
                    $sidebar_query = new WP_Query( array( 'posts_per_page' => 3, 'offset' => 5 ) );
                    if ( $sidebar_query->have_posts() ) : while ( $sidebar_query->have_posts() ) : $sidebar_query->the_post(); ?>
                    <a class="group block" href="<?php the_permalink(); ?>">
                        <div class="flex gap-4 items-start">
                            <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform')); ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h5 class="font-headline font-bold text-sm leading-snug group-hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </h5>
                                <span class="text-[9px] font-label font-bold text-on-surface-variant uppercase tracking-widest mt-1 block"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </section>
            
            <!-- Newsletter Card -->
            <div class="bg-surface-container p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <span class="material-symbols-outlined text-primary mb-4">bolt</span>
                <h4 class="font-headline font-bold mb-2">Resumo Semanal</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed mb-6">Mergulhos técnicos e mudanças no mercado toda terça-feira.</p>
                <button class="w-full py-3 bg-slate-900 text-white dark:bg-slate-50 dark:text-slate-900 font-bold rounded hover:opacity-90 transition-all text-xs">Assine Agora</button>
            </div>

            <!-- Publicidade Final (Dinâmico) -->
            <?php sts_display_ad('sidebar_bottom_ad', '
            <div class="w-full h-96 bg-surface-container-low flex items-center justify-center border border-dashed border-outline-variant rounded-xl group hover:bg-surface-container transition-colors">
                <span class="text-outline font-label text-[10px] tracking-widest uppercase opacity-40 [writing-mode:vertical-lr]">Publicidade Lateral</span>
            </div>'); ?>
        </div>
    </aside>
</main>

<?php get_footer(); ?>
