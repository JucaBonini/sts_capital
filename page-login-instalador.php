<?php
/**
 * Template Name: Login do Instalador (Premium)
 */

if ( is_user_logged_in() ) {
    wp_redirect( home_url('/dashboard-instalador') );
    exit;
}

get_header(); ?>

<main class="min-h-screen pt-40 pb-20 bg-slate-50 dark:bg-slate-950 flex items-center justify-center px-8 relative overflow-hidden">
    
    <!-- Elementos Decorativos -->
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-primary opacity-[0.03] rounded-full blur-[100px]"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-secondary opacity-[0.03] rounded-full blur-[100px]"></div>

    <div class="w-full max-w-md relative z-10">
        
        <div class="text-center mb-12">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary block mb-4">Portal do Parceiro</span>
            <h1 class="text-4xl font-headline font-black text-on-surface mb-2 tracking-tighter">Acesse seu Painel.</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Gerencie seus leads e perfil solar</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-10 md:p-12 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50">
            
            <?php if ( isset($_GET['login']) && $_GET['login'] == 'failed' ) : ?>
                <div class="mb-8 p-4 bg-red-50 text-red-600 rounded-xl text-xs font-bold flex items-center gap-3 border border-red-100">
                    <span class="material-symbols-outlined text-sm">error</span>
                    E-mail ou senha incorretos. Tente novamente.
                </div>
            <?php endif; ?>

            <form action="<?php echo esc_url( site_url('wp-login.php', 'login_post') ); ?>" method="post" class="space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 px-1">E-mail de Acesso</label>
                    <div class="relative">
                        <input type="text" name="log" placeholder="seu@email.com" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 text-on-surface focus:ring-2 focus:ring-primary h-16 transition-all" required />
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-300">alternate_email</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400">Senha</label>
                        <a href="<?php echo wp_lostpassword_url(); ?>" class="text-[9px] font-black uppercase tracking-widest text-primary hover:underline">Esqueceu?</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="pwd" placeholder="••••••••" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary h-16 transition-all" required />
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-300">lock</span>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:translate-y-[-2px] hover:shadow-xl transition-all shadow-lg active:scale-95">
                        Entrar no Sistema
                    </button>
                    <input type="hidden" name="redirect_to" value="<?php echo home_url('/dashboard-instalador'); ?>" />
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-50 dark:border-slate-800 text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-4">Ainda não é parceiro?</p>
                <a href="<?php echo home_url('/cadastro-empresa'); ?>" class="bg-primary/10 text-primary px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[9px] hover:bg-primary hover:text-white transition-all">
                    Solicitar Credenciamento
                </a>
            </div>
        </div>

        <p class="mt-10 text-center text-[10px] text-slate-400 uppercase tracking-[0.3em]">Capital Consciente Hub v2.0</p>
    </div>
</main>

<?php get_footer(); ?>
