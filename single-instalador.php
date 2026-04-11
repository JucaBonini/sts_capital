<?php get_header(); ?>

<main class="pt-32 pb-20 max-w-screen-2xl mx-auto px-8">
    
    <div class="mb-8">
        <?php sts_capital_breadcrumbs(); ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
    <article class="lg:col-span-8">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <header class="mb-12">
                <!-- Voltar ao Diretório -->
                <a href="<?php echo get_post_type_archive_link('instalador'); ?>" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary transition-colors mb-12 group">
                    <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Voltar ao Hub de Instaladores
                </a>

                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center mb-8">
                    <!-- Logo da Empresa -->
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="w-32 h-32 rounded-3xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-4 shadow-xl flex items-center justify-center">
                        <?php the_post_thumbnail('medium', array('class' => 'max-w-full max-h-full object-contain')); ?>
                    </div>
                    <?php endif; ?>

                    <div>
                        <div class="flex flex-wrap items-center gap-4 mb-4">
                            <?php 
                            $is_premium = get_post_meta(get_the_ID(), '_sts_is_premium', true) === '1';
                            if ($is_premium) : ?>
                                <span class="text-[10px] bg-amber-400 text-amber-950 px-4 py-1.5 rounded-full font-black uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-amber-400/20">
                                    <span class="material-symbols-outlined text-[16px]">grade</span> Parceiro Premium
                                </span>
                            <?php else : ?>
                                <span class="text-[10px] bg-primary/10 text-primary px-3 py-1 rounded-full font-black uppercase tracking-widest border border-primary/20 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[14px]">verified</span> Empresa Verificada
                                </span>
                            <?php endif; ?>

                            <span class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full">
                                <?php echo get_post_meta(get_the_ID(), '_sts_location_raw', true); ?>
                            </span>
                        </div>

                        <h1 class="text-5xl md:text-7xl font-headline font-black tracking-tighter text-on-surface leading-none">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

                <div class="prose prose-slate dark:prose-invert max-w-none text-xl leading-relaxed text-slate-600 dark:text-slate-400 mt-12">
                    <?php the_content(); ?>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-8 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 group hover:border-primary/20 transition-all">
                        <span class="material-symbols-outlined text-primary text-3xl mb-4">call</span>
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Telefone</h4>
                        <p class="font-bold text-on-surface"><?php echo get_post_meta(get_the_ID(), '_sts_phone', true) ?: 'Não informado'; ?></p>
                    </div>
                    <div class="p-8 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 group hover:border-primary/20 transition-all">
                        <span class="material-symbols-outlined text-primary text-3xl mb-4">alternate_email</span>
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">E-mail Corporativo</h4>
                        <p class="font-bold text-on-surface"><?php echo get_post_meta(get_the_ID(), '_sts_email', true) ?: 'Não informado'; ?></p>
                    </div>
                    <div class="p-8 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 group hover:border-primary/20 transition-all">
                        <span class="material-symbols-outlined text-primary text-3xl mb-4">language</span>
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Website Oficial</h4>
                        <p class="font-bold text-on-surface truncate"><?php echo get_post_meta(get_the_ID(), '_sts_website', true) ?: 'Não informado'; ?></p>
                    </div>
                </div>
            </header>

                <!-- SEÇÃO DE AVALIAÇÕES (VOZ DO CLIENTE) -->
                <section id="reviews" class="mt-20 pt-20 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-12">
                        <div>
                            <h3 class="text-3xl font-black text-on-surface mb-2">Voz do Cliente</h3>
                            <p class="text-slate-400 text-sm">O que dizem sobre esta empresa.</p>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-black text-amber-500 mb-1"><?php echo $avg_rating; ?></div>
                            <?php sts_capital_display_stars($avg_rating); ?>
                        </div>
                    </div>

                    <?php 
                    $comments = get_comments(array('post_id' => get_the_ID(), 'status' => 'approve'));
                    if ($comments) : ?>
                        <div class="space-y-8 mb-16">
                            <?php foreach ($comments as $comment) : 
                                $rating = get_comment_meta($comment->comment_ID, 'sts_rating', true);
                            ?>
                                <div class="bg-slate-50 dark:bg-slate-900 p-8 rounded-3xl border border-slate-100 dark:border-slate-800">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                                <?php echo substr($comment->comment_author, 0, 1); ?>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-on-surface"><?php echo $comment->comment_author; ?></h4>
                                                <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest"><?php echo get_comment_date('d \d\e F, Y', $comment); ?></span>
                                            </div>
                                        </div>
                                        <?php if ($rating) sts_capital_display_stars($rating); ?>
                                    </div>
                                    <div class="text-slate-600 dark:text-slate-400 leading-relaxed italic">
                                        "<?php echo $comment->comment_content; ?>"
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-slate-50 dark:bg-slate-900 p-12 rounded-3xl text-center mb-16 italic text-slate-400">
                            Nenhuma avaliação ainda. Seja o primeiro a avaliar!
                        </div>
                    <?php endif; ?>

                    <!-- Form de Avaliação -->
                    <div class="bg-white dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 p-10 md:p-16 rounded-[40px]">
                        <?php 
                        $args = array(
                            'title_reply' => '<span class="text-2xl font-black text-on-surface">Deixe sua Avaliação</span>',
                            'label_submit' => 'Enviar Depoimento',
                            'class_submit' => 'bg-primary text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-[11px] hover:scale-105 transition-all cursor-pointer border-none mt-6 shadow-xl shadow-primary/20',
                            'comment_field' => '<div class="mb-4"><label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Sua Opinião</label><textarea id="comment" name="comment" rows="5" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl p-6 text-sm focus:ring-2 focus:ring-primary" required></textarea></div>',
                            'fields' => array(
                                'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"><div><label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Seu Nome</label><input name="author" type="text" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl p-4 text-sm focus:ring-2 focus:ring-primary" required></div>',
                                'email' => '<div><label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Seu E-mail</label><input name="email" type="email" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl p-4 text-sm focus:ring-2 focus:ring-primary" required></div></div>',
                            ),
                        );
                        comment_form($args); 
                        ?>
                    </div>
                </section>

        <?php endwhile; endif; ?>
    </article>

    <!-- Sidebar de Ação e Leads -->
    <aside class="lg:col-span-4">
        <div class="sticky top-24 flex flex-col gap-12 lg:pl-10">
            
            <div class="bg-slate-900 p-10 rounded-3xl text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                     <h3 class="font-headline font-black text-3xl mb-6">Solicitar Orçamento.</h3>
                     <p class="text-sm opacity-80 leading-relaxed max-w-xs mb-10">Fale diretamente com os consultores da <strong><?php the_title(); ?></strong> e receba sua análise de viabilidade solar.</p>
                     
                     <?php 
                     $wa = get_post_meta(get_the_ID(), '_sts_whatsapp', true); 
                     if ($wa) : ?>
                     <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $wa); ?>" class="w-full bg-emerald-500 text-white py-5 rounded-2xl flex items-center justify-center gap-3 font-black uppercase tracking-widest text-sm hover:scale-[1.02] active:scale-100 transition-all shadow-xl shadow-emerald-500/20">
                         <span class="material-symbols-outlined">chat</span> Chamar no WhatsApp
                     </a>
                     <?php endif; ?>

                    <?php $address = get_post_meta(get_the_ID(), '_sts_address', true); ?>
                    <?php if ($address) : ?>
                    <div class="flex items-center gap-4 text-slate-400 mt-6">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        <span class="text-sm font-medium"><?php echo esc_html($address); ?></span>
                    </div>
                    <?php endif; ?>

                     <div class="mt-8 flex items-center justify-center gap-2 opacity-40">
                         <span class="material-symbols-outlined text-[14px]">bolt</span>
                         <span class="text-[9px] font-black uppercase tracking-widest">Tempo de resposta: ~2h</span>
                     </div>
                </div>
                <!-- Micro-animação visual -->
                <div class="absolute -right-20 -bottom-20 w-48 h-48 bg-primary opacity-20 rounded-full blur-[60px] group-hover:bg-primary/40 transition-all"></div>
            </div>

            <!-- Ad Space Sidebar -->
            <?php sts_display_ad('sidebar_top_ad'); ?>

        </div>
    </aside>

</main>

<?php get_footer(); ?>
