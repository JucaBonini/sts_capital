<?php
/**
 * Template Name: Dashboard do Instalador (Premium)
 */

if ( !is_user_logged_in() ) {
    wp_redirect( home_url('/login-instalador') );
    exit;
}

get_header(); 

$current_user = wp_get_current_user();
$args = array(
    'post_type'   => 'instalador',
    'post_status' => array('publish', 'pending', 'draft'),
    'author'      => $current_user->ID,
    'posts_per_page' => 1
);
$query = new WP_Query($args);
$my_company = $query->have_posts() ? $query->posts[0] : null;
?>

<main class="pt-40 pb-24 bg-slate-50 dark:bg-slate-950 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-8">
        
        <!-- Header do Dashboard -->
        <header class="flex flex-col md:flex-row justify-between items-end md:items-center gap-6 mb-16">
            <div>
                <nav class="flex items-center gap-2 mb-4">
                    <span class="text-[9px] font-black uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full">Sistema Ativo</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Dashboard v2.0</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-headline font-black text-on-surface tracking-tighter">Central do Parceiro.</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-on-surface"><?php echo $current_user->display_name; ?></p>
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest leading-none"><?php echo $current_user->user_email; ?></p>
                </div>
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-red-500 hover:bg-red-50 transition-all shadow-sm">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </header>

        <?php if ( $my_company ) : 
            $status = $my_company->post_status;
            $is_premium = get_post_meta($my_company->ID, '_sts_is_premium', true) === '1';
        ?>
            <!-- Grid de Estatísticas Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <!-- Status Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-4">Status da Empresa</span>
                    <div class="flex items-center gap-4">
                        <?php if ($status === 'publish') : ?>
                            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="font-bold text-on-surface">No Ar ✅</span>
                        <?php else : ?>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <span class="font-bold text-on-surface">Em Revisão ⏳</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Plano Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-4">Plano Atual</span>
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined <?php echo $is_premium ? 'text-amber-500' : 'text-slate-300'; ?>">workspace_premium</span>
                        <span class="font-bold text-on-surface"><?php echo $is_premium ? 'PREMIUM' : 'GRATUITO'; ?></span>
                    </div>
                </div>

                <!-- Mock Stats Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-4">Visualizações (Mês)</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-on-surface tracking-tighter">--</span>
                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Ativando em Breve</span>
                    </div>
                </div>

                <!-- Mock Leads Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-4">Leads Gerados</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-on-surface tracking-tighter">--</span>
                        <span class="material-symbols-outlined text-xs text-primary">bolt</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Formulário de Edição -->
                <div class="lg:col-span-8">
                    <?php if ( isset($_GET['update']) && $_GET['update'] === 'success' ) : ?>
                        <div class="mb-10 p-6 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-100 flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                            <span class="material-symbols-outlined bg-emerald-500 text-white w-10 h-10 rounded-full flex items-center justify-center">done</span>
                            <div>
                                <strong class="text-sm block">Alterações salvas com sucesso!</strong>
                                <span class="text-[10px] opacity-80 uppercase font-black tracking-widest">Suas edições estão em nossa fila de revisão.</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="bg-white dark:bg-slate-900 p-10 md:p-16 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl">
                        <h2 class="text-2xl font-headline font-black text-on-surface mb-10">Editar Perfil Corporativo.</h2>
                        
                        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="space-y-10">
                            <input type="hidden" name="action" value="sts_instalador_update">
                            <input type="hidden" name="post_id" value="<?php echo $my_company->ID; ?>">
                            <?php wp_nonce_field('sts_update_action', 'sts_update_nonce'); ?>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Nome Fantasia</label>
                                <input type="text" name="hub_name" value="<?php echo esc_attr($my_company->post_title); ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 text-on-surface focus:ring-2 focus:ring-primary text-xl font-bold tracking-tight h-16" required />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">WhatsApp Principal</label>
                                    <input type="text" name="hub_whatsapp" value="<?php echo esc_attr(get_post_meta($my_company->ID, '_sts_whatsapp', true)); ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" />
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Website Oficial</label>
                                    <input type="url" name="hub_website" value="<?php echo esc_attr(get_post_meta($my_company->ID, '_sts_website', true)); ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" />
                                </div>
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Endereço Completo (Rua, Número, Bairro)</label>
                                    <input type="text" name="hub_address" value="<?php echo esc_attr(get_post_meta($my_company->ID, '_sts_address', true)); ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" />
                                </div>
                            </div>

                            <!-- Localização Dinâmica -->
                            <div class="p-10 bg-slate-50 dark:bg-slate-800/30 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-primary mb-8 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px]">location_on</span> Região de Atuação Principal
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 px-1">Estado (UF)</label>
                                        <?php
                                        $states = get_terms(array('taxonomy' => 'regiao', 'parent' => 0, 'hide_empty' => false));
                                        $current_terms = wp_get_post_terms($my_company->ID, 'regiao');
                                        $current_city_id = !empty($current_terms) ? $current_terms[0]->term_id : 0;
                                        $current_state_id = 0;
                                        if ($current_city_id) {
                                            $term = get_term($current_city_id, 'regiao');
                                            $current_state_id = ($term->parent == 0) ? $term->term_id : $term->parent;
                                        }
                                        ?>
                                        <select id="state-select" name="regiao_parent" class="w-full bg-white dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary appearance-none shadow-sm h-16 text-sm font-bold">
                                            <option value="">Selecione o Estado</option>
                                            <?php foreach ($states as $state) : ?>
                                                <option value="<?php echo $state->term_id; ?>" <?php selected($current_state_id, $state->term_id); ?>><?php echo $state->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 px-1">Cidade Sede</label>
                                        <select id="city-select" name="regiao" class="w-full bg-white dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary appearance-none shadow-sm h-16 text-sm font-bold disabled:opacity-50" <?php echo !$current_state_id ? 'disabled' : ''; ?>>
                                            <option value="">Escolha o Estado</option>
                                            <?php 
                                            if ($current_state_id) {
                                                $cities = get_terms(array('taxonomy' => 'regiao', 'parent' => $current_state_id, 'hide_empty' => false));
                                                foreach ($cities as $city) {
                                                    echo '<option value="'.$city->slug.'" '.selected($current_city_id, $city->term_id, false).'>'.$city->name.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Descrição e Diferenciais</label>
                                <textarea name="hub_desc" rows="8" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 text-on-surface focus:ring-2 focus:ring-primary" required><?php echo esc_textarea($my_company->post_content); ?></textarea>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="bg-slate-900 text-white px-12 py-6 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:translate-y-[-2px] hover:shadow-2xl transition-all shadow-xl active:scale-95">
                                    Salvar Alterações
                                </button>
                                <p class="mt-6 text-[9px] text-slate-400 uppercase tracking-widest font-bold">Nota: Seu perfil passará por uma rápida moderação antes de ser atualizado publicamente.</p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar de Ações -->
                <aside class="lg:col-span-4 space-y-8">
                    
                    <?php if ( isset($_GET['payment']) && $_GET['payment'] === 'success' ) : ?>
                        <div class="bg-emerald-500 p-8 rounded-[2.5rem] text-white shadow-2xl animate-bounce">
                            <span class="material-symbols-outlined text-4xl mb-4">check_circle</span>
                            <h3 class="font-black text-xl mb-2 leading-tight">Pagamento Recebido!</h3>
                            <p class="text-xs opacity-90 leading-relaxed">Em instantes seu selo aparecerá no seu perfil. Seja bem-vindo ao grupo de elite!</p>
                        </div>
                    <?php endif; ?>

                    <?php if ( isset($_GET['payment']) && $_GET['payment'] === 'cancel' ) : ?>
                        <div class="bg-slate-200 p-8 rounded-[2.5rem] text-slate-600 border border-slate-300">
                             <h3 class="font-black text-lg mb-2 leading-tight">Pagamento Cancelado</h3>
                            <p class="text-[10px] leading-relaxed">A transação não foi concluída. Caso precise de ajuda, entre em contato.</p>
                        </div>
                    <?php endif; ?>

                    <?php if (!$is_premium) : ?>
                        <div class="bg-gradient-to-br from-amber-400 to-amber-600 p-10 rounded-[2.5rem] text-amber-950 shadow-2xl shadow-amber-500/30 relative overflow-hidden group">
                            <div class="relative z-10">
                                <span class="material-symbols-outlined text-4xl mb-4">rocket_launch</span>
                                <h3 class="font-headline font-black text-2xl mb-4 leading-tight">Destaque Ouro.</h3>
                                <p class="text-sm font-bold opacity-80 mb-8 leading-relaxed">Apareça no topo das buscas no seu Estado e Cidade. O destaque aumenta sua taxa de leads em até 500%.</p>
                                <a href="?sts_action=checkout" class="inline-block bg-slate-900 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:scale-105 transition-all shadow-lg">Subir para Plano Ouro</a>
                            </div>
                            <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[160px]">local_fire_department</span>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] border-2 border-amber-500 shadow-2xl relative overflow-hidden">
                            <div class="relative z-10 text-center">
                                <span class="material-symbols-outlined text-amber-500 text-5xl mb-4">verified</span>
                                <h3 class="font-headline font-black text-xl text-on-surface mb-2">Membro Premium</h3>
                                <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-slate-400">Suas vantagens estão ativas</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>

        <?php else : ?>
            <!-- ONBOARDING PREMIUM: Usuário Logado Sem Empresa -->
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary block mb-4">Bem-vindo ao Hub Solar</span>
                    <h2 class="text-4xl font-headline font-black text-on-surface mb-4 tracking-tighter">Vamos publicar sua empresa?</h2>
                    <p class="text-slate-500 max-w-lg mx-auto">Como assinante, você já tem acesso ao portal. Agora, complete o perfil da sua empresa para começar a receber leads qualificados.</p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-10 md:p-16 border border-slate-100 dark:border-slate-800 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-[0.03]">
                        <span class="material-symbols-outlined text-[150px]">business_center</span>
                    </div>

                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data" class="relative z-10 space-y-10">
                        <input type="hidden" name="action" value="sts_onboarding_company">
                        <input type="hidden" name="sts_onboarding_company" value="1">

                        <!-- Seção 1: Identidade -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Nome Fantasia da Empresa</label>
                                <input type="text" name="company_name" placeholder="Ex: Solar Tech Brasil" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Logo da Empresa</label>
                                <input type="file" name="company_logo" class="text-xs text-slate-400 mt-4" accept="image/*" />
                            </div>
                        </div>

                        <!-- Seção 2: Contato e Link -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">WhatsApp de Vendas</label>
                                <input type="text" name="company_whatsapp" placeholder="DD9XXXXXXXX" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Website Oficial</label>
                                <input type="url" name="company_website" placeholder="https://www.site.com.br" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" />
                            </div>
                        </div>

                        <!-- Seção 3: Endereço -->
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Endereço Completo</label>
                            <input type="text" name="company_address" placeholder="Rua, Número, Bairro..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                        </div>

                        <!-- Seção 4: Localização (Dynamic) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-100 dark:border-slate-800">
                            <?php $states = get_terms(array('taxonomy' => 'regiao', 'parent' => 0, 'hide_empty' => false)); ?>
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-primary px-1">Estado Sede</label>
                                <select id="state-select" name="regiao_parent" class="w-full bg-white dark:bg-slate-800 border-none rounded-2xl px-6 h-14 appearance-none shadow-sm" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($states as $state) : ?>
                                        <option value="<?php echo $state->term_id; ?>"><?php echo $state->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-primary px-1">Cidade Principal</label>
                                <select id="city-select" name="regiao" disabled class="w-full bg-white dark:bg-slate-800 border-none rounded-2xl px-6 h-14 appearance-none shadow-sm disabled:opacity-50">
                                    <option value="">Aguardando Estado...</option>
                                </select>
                            </div>
                        </div>

                        <!-- Seção 5: Sobre -->
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Bio / Histórico da Empresa</label>
                            <textarea name="company_bio" rows="5" placeholder="Conte sobre sua experiência no setor solar..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary" required></textarea>
                        </div>

                        <!-- Seção Termos e Consentimento -->
                        <div class="p-10 bg-slate-900 text-white rounded-[2.5rem] border border-slate-800 shadow-2xl relative overflow-hidden group">
                            <div class="relative z-10">
                                <h4 class="text-xl font-headline font-black mb-4">Políticas do Ecossistema Hub Solar</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-emerald-400 font-black uppercase tracking-widest text-[9px]">
                                            <span class="material-symbols-outlined text-sm">check_circle</span> Plano Gratuito
                                        </div>
                                        <p class="text-[11px] text-slate-400">Listagem vitalícia sem custo. Sua empresa visível no diretório geral de instaladores.</p>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-amber-500 font-black uppercase tracking-widest text-[9px]">
                                            <span class="material-symbols-outlined text-sm">stars</span> Plano Premium (Mensal)
                                        </div>
                                        <p class="text-[11px] text-slate-400">Destaque Ouro. Sua empresa no topo das buscas estaduais e prioridade máxima nos leads.</p>
                                    </div>
                                </div>
                                
                                <label class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl cursor-pointer hover:bg-white/10 transition-all border border-white/10">
                                    <input type="checkbox" required class="w-6 h-6 rounded border-white/20 text-primary focus:ring-primary bg-transparent">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-200">Concordo com os Termos e as Condições de Uso</span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-primary text-white py-6 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:translate-y-[-2px] hover:shadow-2xl transition-all shadow-xl active:scale-95">
                                Publicar Perfil da Empresa
                            </button>
                            <p class="mt-8 text-center text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em]">Seu perfil será revisado por nossa equipe técnica em até 24h.</p>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state-select');
    const citySelect = document.getElementById('city-select');

    if (stateSelect) {
        stateSelect.addEventListener('change', function() {
            const stateId = this.value;
            citySelect.innerHTML = '<option value="">Carregando...</option>';
            citySelect.disabled = true;

            if (!stateId) return;

            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=sts_get_cities&state_id=' + stateId)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Selecione a Cidade</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.slug}">${city.name}</option>`;
                    });
                    citySelect.disabled = false;
                });
        });
    }
});
</script>

<?php get_footer(); ?>
