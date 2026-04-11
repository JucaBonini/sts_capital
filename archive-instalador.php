<?php get_header(); ?>

<main class="pt-32 pb-20 max-w-screen-2xl mx-auto px-8">
    
    <div class="mb-8">
        <?php sts_capital_breadcrumbs(); ?>
    </div>
    
    <header class="mb-16 max-w-4xl border-l-4 border-primary pl-8">
        <span class="text-primary font-label text-xs uppercase tracking-[0.2em] mb-4 block font-bold">Diretório de Elite</span>
        <h1 class="text-5xl md:text-6xl font-headline font-black tracking-tighter text-on-surface mb-6 leading-none">
            Hub de<br><span class="text-primary">Instaladores Solares.</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
            Encontre profissionais certificados e empresas de engenharia especializadas em energia fotovoltaica, organizados por estado e cidade.
        </p>
        
        <div class="mt-8 flex gap-4">
            <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm uppercase tracking-widest hover:translate-y-[-2px] transition-all">Cadastrar minha Instaladora</a>
        </div>
    </header>

    <!-- Barra de Filtros e Busca -->
    <section class="mb-12 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row gap-6 items-center justify-between">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <span class="material-symbols-outlined text-primary">filter_list</span>
            <span class="text-xs font-black uppercase tracking-widest text-on-surface">Filtrar por Região:</span>
        </div>
        
        <form id="filter-form" action="<?php echo home_url('/'); ?>" method="get" class="flex flex-col md:flex-row gap-4 w-full md:w-auto flex-grow max-w-5xl">
            <input type="hidden" name="post_type" value="instalador">
            
            <!-- Busca por Nome -->
            <div class="relative flex-grow md:max-w-[200px]">
                <input type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="Empresa..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-10 py-3 text-sm font-medium focus:ring-2 focus:ring-primary">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            </div>

            <!-- Filtro por Estado -->
            <div class="relative flex-grow md:max-w-[200px]">
                <?php
                $states = get_terms( array(
                    'taxonomy' => 'regiao',
                    'parent'   => 0,
                    'hide_empty' => false,
                ) );
                ?>
                <select id="state-select" name="regiao_parent" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary appearance-none">
                    <option value="">Estado (Todos)</option>
                    <?php foreach ($states as $state) : ?>
                        <option value="<?php echo $state->term_id; ?>"><?php echo esc_html($state->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm">expand_more</span>
            </div>

            <!-- Filtro por Cidade -->
            <div class="relative flex-grow md:max-w-[250px]">
                <select id="city-select" name="regiao" disabled class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary appearance-none disabled:opacity-50">
                    <option value="">Cidade (Selecione o Estado)</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm">expand_more</span>
            </div>

            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:opacity-90 transition-all">Buscar</button>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stateSelect = document.getElementById('state-select');
            const citySelect = document.getElementById('city-select');

            stateSelect.addEventListener('change', function() {
                const stateId = this.value;
                citySelect.innerHTML = '<option value="">Carregando cidades...</option>';
                citySelect.disabled = true;

                if (!stateId) {
                    citySelect.innerHTML = '<option value="">Cidade (Selecione o Estado)</option>';
                    return;
                }

                fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=sts_get_cities&state_id=' + stateId)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Todas as Cidades</option>';
                        data.forEach(city => {
                            citySelect.innerHTML += `<option value="${city.slug}">${city.name}</option>`;
                        });
                        citySelect.disabled = false;
                    });
            });
        });
        </script>

        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            Exibindo <?php echo $wp_query->found_posts; ?> Empresas
        </div>
    </section>

    <!-- Grid de Empresas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-20">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            $is_premium = get_post_meta(get_the_ID(), '_sts_is_premium', true) === '1';
            $premium_class = $is_premium ? 'border-amber-400/50 shadow-xl bg-gradient-to-br from-white to-amber-50/30 dark:from-slate-900 dark:to-amber-900/10' : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800';
        ?>
            <article class="<?php echo $premium_class; ?> border rounded-3xl p-8 hover:shadow-2xl hover:translate-y-[-4px] transition-all group flex flex-col h-full overflow-hidden relative">
                
                <?php if ($is_premium) : ?>
                    <div class="absolute -right-2 -top-2 w-24 h-24 bg-amber-400/20 rounded-full blur-[40px]"></div>
                    <div class="absolute top-0 right-0 bg-amber-400 text-amber-950 text-[9px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm z-10 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">grade</span> Destaque Premium
                    </div>
                <?php else : ?>
                    <div class="absolute -right-2 -top-2 w-12 h-12 bg-primary/10 rounded-full blur-[20px] group-hover:bg-primary/30 transition-all"></div>
                <?php endif; ?>
                
                <div class="mb-6 flex justify-between items-start">
                    <span class="text-[9px] font-black uppercase tracking-widest text-primary flex items-center gap-2 border border-primary/20 bg-primary/5 px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[12px]">verified</span> Verificada</span>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400"><?php echo get_post_meta(get_the_ID(), '_sts_location_raw', true); ?></span>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-100 dark:border-slate-800 p-2 shadow-inner">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-contain')); ?>
                        <?php else : ?>
                            <span class="material-symbols-outlined text-slate-300 text-3xl">image</span>
                        <?php endif; ?>
                    </div>
                </div>

                <h3 class="font-headline font-black text-xl mb-4 text-on-surface leading-tight transition-colors group-hover:text-primary">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 mb-8 flex-grow leading-relaxed">
                    <?php echo get_the_excerpt(); ?>
                </p>

                <div class="space-y-3">
                    <?php 
                    $wa = get_post_meta(get_the_ID(), '_sts_whatsapp', true); 
                    if ($wa) : ?>
                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $wa); ?>?text=Ol%C3%A1%2C%20vi%20seu%20perfil%20no%20Capital%20Consciente" class="w-full bg-emerald-500 text-white font-black py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-emerald-600 transition-colors uppercase text-[10px] tracking-widest">
                        <span class="material-symbols-outlined text-[18px]">chat</span> WhatsApp Direto
                    </a>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="w-full bg-slate-100 dark:bg-slate-800 text-on-surface font-black py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all uppercase text-[10px] tracking-widest">
                        Ver Perfil Completo
                    </a>
                </div>
            </article>
        <?php endwhile; else : ?>
            <div class="col-span-full py-20 text-center bg-slate-50 dark:bg-slate-900 rounded-3xl">
                <p class="text-slate-500">Nenhuma instaladora cadastrada nesta região no momento.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <div class="flex justify-center border-t border-slate-100 dark:border-slate-800 pt-10">
        <?php the_posts_pagination(); ?>
    </div>
</main>

<?php get_footer(); ?>
