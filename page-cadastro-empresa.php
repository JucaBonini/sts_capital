<?php
/**
 * Template Name: Cadastro de Empresa (Passo a Passo)
 */

if ( isset($_GET['registration']) && $_GET['registration'] === 'success' ) :
    get_header(); ?>
    <main class="pt-40 pb-24 bg-slate-50 dark:bg-slate-950 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white dark:bg-slate-900 rounded-[3rem] p-12 text-center border border-slate-100 dark:border-slate-800 shadow-2xl animate-in zoom-in-95 duration-500">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-4xl">verified</span>
            </div>
            <h1 class="text-3xl font-headline font-black text-on-surface mb-4">Cadastro Enviado!</h1>
            <p class="text-slate-500 mb-10 leading-relaxed font-medium">Sua conta foi criada e os dados da empresa foram enviados para nossa redação. Você receberá um e-mail assim que o perfil for aprovado.</p>
            <div class="space-y-4">
                <a href="<?php echo home_url('/login-instalador'); ?>" class="block w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:translate-y-[-2px] transition-all">Acessar meu Dashboard</a>
                <a href="<?php echo home_url(); ?>" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary">Voltar para a Home</a>
            </div>
        </div>
    </main>
    <?php get_footer();
    exit;
endif;

get_header(); ?>

<main class="pt-40 pb-24 bg-slate-50 dark:bg-slate-950 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-16">
        
        <!-- Sidebar de Progresso (Visível em Desktop) -->
        <aside class="lg:col-span-4 transition-opacity">
            <div class="sticky top-24 bg-white dark:bg-slate-900 p-10 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary block mb-4">Unidade de Negócios</span>
                <h2 class="font-headline font-black text-3xl text-on-surface mb-10 leading-tight">Cadastre sua Instaladora.</h2>
                
                <nav class="space-y-8 relative">
                    <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-slate-100 dark:bg-slate-800"></div>
                    
                    <div class="step-item active flex items-center gap-6 relative" data-step="1">
                        <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs ring-8 ring-primary/10 z-10">1</span>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Passo 01</span>
                            <span class="font-bold text-sm text-on-surface">Dados de Acesso</span>
                        </div>
                    </div>

                    <div class="step-item flex items-center gap-6 relative" data-step="2">
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center font-bold text-xs z-10">2</span>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Passo 02</span>
                            <span class="font-bold text-sm text-slate-400">Identidade & Bio</span>
                        </div>
                    </div>

                    <div class="step-item flex items-center gap-6 relative" data-step="3">
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center font-bold text-xs z-10">3</span>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Passo 03</span>
                            <span class="font-bold text-sm text-slate-400">Localização & Contato</span>
                        </div>
                    </div>
                </nav>

                <div class="mt-16 pt-8 border-t border-slate-100 dark:border-slate-800 text-center">
                    <p class="text-[10px] text-slate-400 mb-4 uppercase tracking-widest">Já possui cadastro?</p>
                    <a href="<?php echo home_url('/login-instalador'); ?>" class="text-[10px] font-black uppercase tracking-widest text-secondary hover:underline">
                        Acessar meu Painel de Controle
                    </a>
                </div>
            </div>
        </aside>

        <!-- Formulário de Cadastro -->
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-16 border border-slate-100 dark:border-slate-800 shadow-2xl relative overflow-hidden">
                
                <form id="multi-step-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="sts_register_company">
                    <?php wp_nonce_field('sts_register_nonce', 'sts_nonce'); ?>

                    <?php if ( isset($_GET['registration']) && $_GET['registration'] === 'email_exists' ) : ?>
                        <div class="mb-10 p-6 rounded-2xl bg-amber-50 text-amber-800 border border-amber-100 flex items-center gap-4 animate-in slide-in-from-top-4 duration-500">
                            <span class="material-symbols-outlined text-3xl">account_circle</span>
                            <div>
                                <strong class="text-sm block">E-mail já cadastrado!</strong>
                                <span class="text-[10px] opacity-80 uppercase font-black tracking-widest">Este e-mail já possui uma conta. Tente <a href="<?php echo home_url('/login-instalador'); ?>" class="underline">fazer login</a>.</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- STEP : Cadastro de Assinante -->
                    <div class="step-content" id="content-step-1">
                        <div class="mb-10">
                            <h3 class="text-2xl font-headline font-black text-on-surface mb-2">Crie sua Conta.</h3>
                            <p class="text-sm text-slate-500 font-medium">Todos os parceiros iniciam como assinantes do portal.</p>
                        </div>

                        <div class="space-y-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Seu Nome Completo</label>
                                <input type="text" name="user_name" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">E-mail de Acesso</label>
                                <input type="email" name="user_email" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Defina uma Senha</label>
                                <input type="password" name="user_pass" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16" required />
                            </div>
                        </div>

                        <div class="mt-8 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <h4 class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-3">Termos e Transparência</h4>
                            <p class="text-[10px] text-slate-500 leading-relaxed mb-4">
                                Ao criar sua conta, você concorda que a listagem básica no portal é <strong>gratuita e vitalícia</strong>. O plano de destaque (Prêmio Ouro) é opcional e requer assinatura mensal. Você é responsável pela veracidade dos dados informados.
                            </p>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" required class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary">
                                <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider group-hover:text-primary transition-colors">Li e concordo com os termos do portal</span>
                            </label>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="w-full bg-primary text-white py-6 rounded-2xl font-black uppercase tracking-[0.2em] text-sm shadow-xl shadow-primary/30 transform transition-all active:scale-95">
                                Criar Conta e Continuar
                            </button>
                            <p class="mt-6 text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest">Já tem conta? <a href="<?php echo home_url('/login-instalador'); ?>" class="text-primary hover:underline">Fazer Login</a></p>
                        </div>
                    </div>
                    <input type="hidden" name="sts_company_registration" value="1">
                    <?php wp_nonce_field('sts_reg_action', 'sts_reg_nonce'); ?>
                </form>

            </div>
        </div>
    </div>
</main>

<script>
function nextStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('content-step-' + step).classList.remove('hidden');

    document.querySelectorAll('.step-item').forEach(el => {
        const itemStep = parseInt(el.dataset.step);
        const icon = el.querySelector('span:first-child');
        if (itemStep < step) {
            icon.classList.remove('bg-primary', 'bg-slate-100', 'ring-8', 'ring-primary/10');
            icon.classList.add('bg-emerald-500', 'text-white');
            icon.innerHTML = 'done';
        } else if (itemStep === step) {
            icon.classList.remove('bg-emerald-500', 'bg-slate-100', 'text-slate-400');
            icon.classList.add('bg-primary', 'text-white', 'ring-8', 'ring-primary/10');
            icon.innerHTML = step;
        } else {
            icon.classList.remove('bg-primary', 'bg-emerald-500', 'text-white', 'ring-8', 'ring-primary/10');
            icon.classList.add('bg-slate-100', 'text-slate-400');
            icon.innerHTML = itemStep;
        }
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state-select');
    const citySelect = document.getElementById('city-select');

    stateSelect.addEventListener('change', function() {
        const stateId = this.value;
        citySelect.innerHTML = '<option value="">Carregando...</option>';
        citySelect.disabled = true;
        if (!stateId) return;

        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=sts_get_cities&state_id=' + stateId)
            .then(response => response.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Selecione sua Cidade</option>';
                data.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.slug}">${city.name}</option>`;
                });
                citySelect.disabled = false;
            });
    });
});
</script>

<?php get_footer(); ?>
