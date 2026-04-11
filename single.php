<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php 
// Lógica de Tempo de Leitura
$content = get_the_content();
$word_count = str_word_count(strip_tags($content));
$reading_time = ceil($word_count / 200); // Média de 200 palavras por minuto
$categories = get_the_category();
?>

<!-- Container Principal com Grid de 3 Colunas -->
<main class="max-w-[1700px] mx-auto px-6 lg:px-12 pt-16 lg:pt-32 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16">
        
        <!-- COLUNA 1: NAVEGAÇÃO DO POST (Sidebar Esquerda - 2 Colunas) -->
        <aside class="hidden lg:block lg:col-span-2">
            <div class="sticky top-32 space-y-12">
                <div>
                    <h3 class="text-on-surface font-black text-lg leading-tight mb-2">Centro de Inteligência</h3>
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Navegação do Post</p>
                </div>

                <nav class="space-y-6">
                    <a href="<?php echo home_url(); ?>" class="flex items-center gap-4 text-slate-400 hover:text-primary transition-all group">
                        <span class="material-symbols-outlined text-[20px]">home</span>
                        <span class="text-xs font-bold">Feed Principal</span>
                    </a>
                    <a href="#" class="flex items-center gap-4 text-emerald-500 transition-all">
                        <span class="material-symbols-outlined text-[20px] animate-pulse">wb_sunny</span>
                        <span class="text-xs font-black">Lendo Agora</span>
                    </a>
                    <a href="#radar" class="flex items-center gap-4 text-slate-400 hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px]">trending_up</span>
                        <span class="text-xs font-bold">Tendências</span>
                    </a>
                    <a href="#newsletter" class="flex items-center gap-4 text-slate-400 hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                        <span class="text-xs font-bold">Newsletter</span>
                    </a>
                </nav>

                <div class="pt-8 pt-8">
                    <a href="<?php echo home_url('/anuncie'); ?>" class="block bg-emerald-700 hover:bg-emerald-800 text-white text-center py-4 rounded-xl font-black uppercase text-[10px] tracking-widest transition-all shadow-lg hover:scale-105">
                        Participe da Rede
                    </a>
                </div>
            </div>
        </aside>

        <!-- COLUNA 2: CONTEÚDO PRINCIPAL (7 Colunas) -->
        <div class="lg:col-span-7">
            
            <header class="mb-12">
                <!-- Top Badges -->
                <div class="flex items-center gap-4 mb-8">
                    <span class="bg-blue-500 text-white font-black text-[9px] uppercase tracking-widest px-4 py-1.5 rounded-full shadow-sm">
                        <?php echo !empty($categories) ? esc_html($categories[0]->name) : 'Notícia'; ?>
                    </span>
                    <span class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                        <?php echo $reading_time; ?> MIN DE LEITURA
                    </span>
                </div>

                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.15em] text-slate-400/60 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">HOME</a>
                    <span class="opacity-30">/</span>
                    <a href="#" class="hover:text-primary transition-colors uppercase"><?php echo !empty($categories) ? esc_html($categories[0]->name) : 'GERAL'; ?></a>
                    <span class="opacity-30">/</span>
                    <span class="text-primary/40">LENDO AGORA</span>
                </nav>

                <h1 class="text-4xl lg:text-[56px] font-headline font-black leading-[1.1] tracking-tight text-on-surface mb-12">
                    <?php the_title(); ?>
                </h1>

                <!-- Autor & Share UI -->
                <div class="flex items-center justify-between py-8 border-y border-slate-100 dark:border-slate-800 mb-12">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 border-2 border-white shadow-xl">
                            <?php echo get_avatar( get_the_author_meta('ID'), 120 ); ?>
                        </div>
                        <div>
                            <p class="font-black text-on-surface text-lg leading-tight"><?php the_author(); ?></p>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">
                                <?php echo get_the_author_meta('expertise') ?: 'Analista de Pesquisa'; ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <button class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary border border-slate-100 dark:border-slate-800 rounded-full transition-all">
                            <span class="material-symbols-outlined text-lg">share</span>
                        </button>
                        <button class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary border border-slate-100 dark:border-slate-800 rounded-full transition-all">
                            <span class="material-symbols-outlined text-lg">bookmark</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Imagem de Destaque -->
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="mb-16 rounded-[2.5rem] overflow-hidden shadow-2xl">
                <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover')); ?>
            </div>
            <?php endif; ?>

            <!-- Artigo -->
            <div class="article-content prose prose-slate dark:prose-invert max-w-none text-lg leading-relaxed text-slate-700 dark:text-slate-300">
                <?php the_content(); ?>
            </div>

            <!-- Footer do Post -->
            <footer class="mt-20 pt-12 border-t border-slate-100 dark:border-slate-800" id="newsletter">
                <div class="bg-indigo-950 p-12 rounded-[3.5rem] text-white overflow-hidden relative group">
                    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div>
                            <h3 class="text-3xl font-black mb-4 leading-tight">Radar Capital:<br>A Newsletter.</h3>
                            <p class="text-sm opacity-70">A análise mais profunda sobre o mercado solar enviada toda segunda-feira.</p>
                        </div>
                        <div id="newsletter-form-container">
                            <form id="newsletter-form" class="flex flex-col gap-4">
                                <input name="email" type="email" placeholder="Seu e-mail corporativo" class="w-full bg-white/10 border-white/20 px-6 py-4 rounded-2xl text-white placeholder-white/30 focus:ring-2 focus:ring-emerald-400" required>
                                <button type="submit" class="w-full bg-emerald-500 text-indigo-950 px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-emerald-400 transition-all">Assinar Análise</button>
                            </form>
                            <div id="newsletter-response" class="hidden text-xs font-bold mt-4 animate-fade-in"></div>
                        </div>
                    </div>
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px]"></div>
                </div>
            </footer>
        </div>

        <!-- COLUNA 3: SIDEBAR DE DESTAQUES (Radar Lateral - 3 Colunas) -->
        <aside class="lg:col-span-3" id="radar">
            <div class="sticky top-32 space-y-12">
                
                <div>
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-on-surface mb-2">Análises em Destaque</h4>
                    <div class="w-12 h-0.5 bg-emerald-500"></div>
                </div>

                <div class="space-y-10">
                    <?php
                    $radar_query = new WP_Query( array( 
                        'posts_per_page' => 3, 
                        'post__not_in' => array( get_the_ID() ) 
                    ));
                    if ( $radar_query->have_posts() ) : while ( $radar_query->have_posts() ) : $radar_query->the_post();
                    ?>
                    <article class="group relative">
                        <div class="aspect-video rounded-2xl overflow-hidden mb-4 shadow-lg group-hover:shadow-emerald-500/20 transition-all">
                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700')); ?>
                        </div>
                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-2">
                            <?php $cat = get_the_category(); echo $cat[0]->name; ?>
                        </span>
                        <h5 class="text-sm font-black leading-tight group-hover:text-emerald-500 transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                    </article>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>

                <!-- Box de Promoção HUB -->
                <div class="bg-slate-50 dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                    <span class="material-symbols-outlined text-emerald-500 text-4xl mb-4">hub</span>
                    <h4 class="font-black text-on-surface mb-2 leading-tight">Hub de Instaladores</h4>
                    <p class="text-[11px] text-slate-500 mb-6 leading-relaxed">Conecte sua empresa de energia solar ao maior portal do Brasil.</p>
                    <a href="<?php echo home_url('/anuncie'); ?>" class="text-[10px] font-black text-emerald-500 uppercase tracking-widest flex items-center gap-2 group">
                        Ver Planos <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>

            </div>
        </aside>

    </div>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
