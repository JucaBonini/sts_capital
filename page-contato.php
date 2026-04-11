<?php
/**
 * Template Name: Página de Contato Luxe
 */

get_header(); ?>

<main class="pt-32 pb-20 max-w-screen-xl mx-auto px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
        
        <!-- Coluna de Informações -->
        <div class="flex flex-col gap-12">
            <header>
                <span class="text-primary font-label text-xs uppercase tracking-[0.2em] mb-4 block font-bold">Contato Direto</span>
                <h1 class="text-5xl md:text-7xl font-headline font-black tracking-tighter text-on-surface leading-none mb-6">
                    Fale com a<br><span class="text-primary">Inteligência.</span>
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed max-w-md">
                    Seja para parcerias estratégicas, dúvidas técnicas sobre energia solar ou sugestões de pauta, nossa equipe está pronta para responder.
                </p>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-4">
                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">E-mail Editorial</span>
                    <a href="mailto:contato@capitalconsciente.com.br" class="text-on-surface font-bold hover:text-primary transition-colors underline decoration-primary/20 hover:decoration-primary">contato@capitalconsciente.com.br</a>
                </div>
                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Parcerias</span>
                    <a href="mailto:parcerias@capitalconsciente.com.br" class="text-on-surface font-bold hover:text-primary transition-colors underline decoration-primary/20 hover:decoration-primary">parcerias@capitalconsciente.com.br</a>
                </div>
                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Redes Sociais</span>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-[18px]">share</span></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-[18px]">alternate_email</span></a>
                    </div>
                </div>
            </div>

            <!-- Mapa / Elemento Visual -->
            <div class="w-full h-48 bg-slate-100 dark:bg-slate-800 rounded-3xl relative overflow-hidden group">
                 <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent"></div>
                 <div class="p-8 relative z-10 flex flex-col justify-end h-full">
                     <span class="text-primary material-symbols-outlined text-4xl mb-4" style="font-variation-settings: 'FILL' 1;">location_on</span>
                     <p class="text-xs font-bold text-on-surface uppercase tracking-widest">Base de Operações: Florianópolis, SC</p>
                 </div>
            </div>
        </div>

        <!-- Coluna do Formulário -->
        <div class="bg-white dark:bg-slate-900 shadow-2xl rounded-3xl p-10 lg:p-12 border border-slate-100 dark:border-slate-800">
            
            <!-- Feedbacks do Form -->
            <?php if ( isset($_GET['contact_sent']) ) : ?>
                <div class="mb-8 p-4 rounded-xl <?php echo $_GET['contact_sent'] === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100'; ?>">
                    <?php 
                        if ($_GET['contact_sent'] === 'success') {
                            echo '<div class="flex items-center gap-2 font-bold"><span class="material-symbols-outlined">check_circle</span> Mensagem enviada com sucesso!</div>';
                        } else {
                            echo '<div class="flex items-center gap-2 font-bold"><span class="material-symbols-outlined">error</span> Erro ao enviar. Tente novamente.</div>';
                        }
                    ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="space-y-6">
                <!-- Ações do WP -->
                <input type="hidden" name="action" value="sts_contact_form">
                <?php wp_nonce_field('sts_contact_action', 'sts_contact_nonce'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Seu Nome</label>
                        <input type="text" name="contact_name" class="w-full bg-slate-50 dark:bg-slate-950/50 border-none rounded-xl px-6 py-4 text-on-surface focus:ring-2 focus:ring-primary transition-all" placeholder="Ex: Roberto Silva" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-1">Seu E-mail</label>
                        <input type="email" name="contact_email" class="w-full bg-slate-50 dark:bg-slate-950/50 border-none rounded-xl px-6 py-4 text-on-surface focus:ring-2 focus:ring-primary transition-all" placeholder="Ex: email@dominio.com" required />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Mensagem</label>
                    <textarea name="contact_message" rows="5" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-6 py-4 text-on-surface focus:ring-2 focus:ring-primary" placeholder="Como podemos ajudar seu projeto?" required></textarea>
                </div>

                <!-- Cloudflare Turnstile Widget -->
                <div class="cf-turnstile" data-sitekey="0x4AAAAAAC3rTM2cujUshIxC"></div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:translate-y-[-2px] hover:shadow-xl transition-all shadow-primary/20">
                        Enviar Mensagem
                    </button>
                    <p class="text-center text-[9px] text-slate-400 mt-6 uppercase leading-relaxed">
                        Ao enviar, você concorda com nossos <a href="#" class="underline">Termos de Uso</a> e <a href="#" class="underline">Política de Privacidade</a>.
                    </p>
                </div>
            </form>
        </div>

    </div>
</main>

<?php get_footer(); ?>
