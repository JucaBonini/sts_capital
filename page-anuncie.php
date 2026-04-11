<?php 
/**
 * Template Name: Página Anuncie (Preços e Vantagens)
 */
get_header(); ?>

<main class="pt-32 pb-20 overflow-hidden">
    
    <!-- Hero Section -->
    <section class="max-w-screen-xl mx-auto px-8 py-20 text-center relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-emerald-500/10 blur-[120px] rounded-full -z-10"></div>
        
        <span class="inline-block bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-8 border border-emerald-500/20">Marketplace de Elite</span>
        <h1 class="text-6xl md:text-8xl font-headline font-black tracking-tighter text-on-surface leading-none mb-10">
            Escale sua empresa de<br><span class="text-primary italic">Energia Solar.</span>
        </h1>
        <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed mb-12">
            O Capital Consciente é o portal de maior autoridade no setor. Escolha o plano que vai colocar sua marca no topo das buscas regionais.
        </p>
    </section>

    <!-- Pricing Tables -->
    <section class="max-w-screen-xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Plano Free -->
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-12 rounded-[40px] shadow-sm relative overflow-hidden group hover:border-slate-300 transition-all">
            <h3 class="text-2xl font-black text-on-surface mb-2">Plano Gratuito</h3>
            <p class="text-slate-400 text-sm mb-8 italic">Para quem está começando.</p>
            
            <div class="text-4xl font-black text-on-surface mb-10">R$ 0<span class="text-sm text-slate-400 font-medium"> /mês</span></div>
            
            <ul class="space-y-6 mb-12 list-none p-0">
                <li class="flex items-center gap-3 text-slate-500 text-sm">
                    <span class="material-symbols-outlined text-slate-300">check_circle</span> Listagem básica no diretório
                </li>
                <li class="flex items-center gap-3 text-slate-500 text-sm">
                    <span class="material-symbols-outlined text-slate-300">check_circle</span> Página de perfil simples
                </li>
                <li class="flex items-center gap-3 text-slate-500 text-sm opacity-50 line-through">
                    <span class="material-symbols-outlined">block</span> Destaque nas buscas por cidade
                </li>
                <li class="flex items-center gap-3 text-slate-500 text-sm opacity-50 line-through">
                    <span class="material-symbols-outlined">block</span> Selo de Parceiro Premium
                </li>
            </ul>

            <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="block w-full text-center py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-300 font-black uppercase tracking-widest text-[10px] hover:bg-slate-100 transition-all">Começar agora</a>
        </div>

        <!-- Plano Premium -->
        <div class="bg-slate-900 border-2 border-emerald-500 p-12 rounded-[40px] shadow-2xl shadow-emerald-500/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 bg-emerald-500 text-slate-900 font-black px-6 py-2 rounded-bl-3xl text-[9px] uppercase tracking-widest">Mais Vendido</div>
            
            <h3 class="text-2xl font-black text-white mb-2">Plano Premium</h3>
            <p class="text-slate-400 text-sm mb-8 italic">Domine sua região e gere leads reais.</p>
            
            <div class="text-4xl font-black text-white mb-10">R$ 97<span class="text-sm text-slate-500 font-medium font-inter"> /mês</span></div>
            
            <ul class="space-y-6 mb-12 list-none p-0">
                <li class="flex items-center gap-3 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-emerald-500">verified</span> <strong>Prioridade Máxima:</strong> Topo das buscas
                </li>
                <li class="flex items-center gap-3 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-emerald-500">verified</span> <strong>Selo de Ouro:</strong> Máxima autoridade
                </li>
                <li class="flex items-center gap-3 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-emerald-500">verified</span> <strong>Rotatividade Justa:</strong> Exposição de elite
                </li>
                <li class="flex items-center gap-3 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-emerald-500">verified</span> <strong>Leads Diretos:</strong> WhatsApp destacado
                </li>
                <li class="flex items-center gap-3 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-emerald-500">verified</span> <strong>Hotsite Premium:</strong> Sem anúncios
                </li>
            </ul>

            <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="block w-full text-center py-4 rounded-2xl bg-emerald-500 text-slate-900 font-black uppercase tracking-widest text-[10px] hover:bg-emerald-400 hover:scale-[1.02] transition-all shadow-xl shadow-emerald-500/20">Quero ser Premium</a>
        </div>

    </section>

    <!-- FAQ Rápido -->
    <section class="max-w-3xl mx-auto px-8 mt-32 text-center">
        <h2 class="text-3xl font-black text-on-surface mb-12">Dúvidas Frequentes</h2>
        <div class="space-y-6 text-left">
            <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl">
                <h4 class="font-bold text-on-surface mb-2">Posso cancelar quando quiser?</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Sim. O plano é mensal, sem contrato de fidelidade. Se não estiver satisfeito, pode cancelar no seu painel.</p>
            </div>
            <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl">
                <h4 class="font-bold text-on-surface mb-2">Como funciona a rotatividade?</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Para ser justo com todos os parceiros Premium, alternamos a posição no topo a cada carregamento de página.</p>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
