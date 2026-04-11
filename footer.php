<?php
/**
 * The template for displaying the footer
 */
?>
<!-- Footer -->
<footer class="bg-slate-900 dark:bg-slate-950 w-full py-20 px-8 border-t border-slate-800">
    <div class="max-w-screen-2xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1 md:col-span-1">
            <div class="text-xl font-black text-white mb-4"><?php echo get_bloginfo('name'); ?></div>
            <p class="text-slate-400 text-xs leading-relaxed mb-6">Arquitetando a transição sustentável através de dados de alta fidelidade e inteligência de engenharia.</p>
            <div class="flex gap-4">
                <a class="text-slate-400 hover:text-emerald-400" href="#"><span class="material-symbols-outlined">public</span></a>
                <a class="text-slate-400 hover:text-emerald-400" href="#"><span class="material-symbols-outlined">hub</span></a>
                <a class="text-slate-400 hover:text-emerald-400" href="#"><span class="material-symbols-outlined">rss_feed</span></a>
            </div>
        </div>
        <div>
            <h6 class="text-white font-bold text-sm mb-6 uppercase tracking-wider">Recursos</h6>
            <ul class="space-y-4 list-none p-0">
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Estudos de Caso</a></li>
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Análise de Mercado</a></li>
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Ferramentas Open Source</a></li>
            </ul>
        </div>
        <div>
            <h6 class="text-white font-bold text-sm mb-6 uppercase tracking-wider">Legal</h6>
            <ul class="space-y-4 list-none p-0">
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Política de Privacidade</a></li>
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Termos de Serviço</a></li>
                <li><a class="text-slate-400 hover:text-emerald-400 transition-colors font-inter text-xs tracking-wider uppercase" href="#">Configurações de Cookies</a></li>
            </ul>
        </div>
        <div>
            <h6 class="text-white font-bold text-sm mb-6 uppercase tracking-wider">Conectar</h6>
            <form id="newsletter-form" class="bg-slate-800 p-1 rounded flex">
                <input id="newsletter-email" name="email" class="bg-transparent border-none text-white text-xs w-full focus:ring-0 px-2" placeholder="Seu MELHOR E-mail" type="email" required/>
                <button type="submit" class="bg-emerald-500 text-slate-900 px-4 py-2 rounded-sm font-black text-[10px] uppercase tracking-widest hover:bg-emerald-400 transition-all">Assinar</button>
            </form>
            <div id="newsletter-message" class="mt-3 text-[10px] font-bold uppercase tracking-widest hidden"></div>
        </div>

        <script>
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('newsletter-email').value;
            const msg = document.getElementById('newsletter-message');
            const btn = this.querySelector('button');
            
            btn.disabled = true;
            btn.innerText = '...';

            const formData = new FormData();
            formData.append('action', 'sts_newsletter');
            formData.append('email', email);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                msg.classList.remove('hidden', 'text-red-400', 'text-emerald-400');
                msg.classList.add(data.success ? 'text-emerald-400' : 'text-red-400');
                msg.innerText = data.data;
                if(data.success) {
                    document.getElementById('newsletter-email').value = '';
                }
            })
            .catch(() => {
                msg.innerText = 'Erro na conexão.';
                msg.classList.add('text-red-400');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerText = 'Assinar';
            });
        });
        </script>
    </div>
    <div class="max-w-screen-2xl mx-auto mt-12 pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-slate-400 font-inter text-xs tracking-wider uppercase">© <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. Engenharia para Sustentabilidade.</p>
        <div class="flex gap-8">
            <a class="text-slate-400 hover:text-emerald-400 text-xs uppercase tracking-widest" href="#">Feed RSS</a>
            <a class="text-slate-400 hover:text-emerald-400 text-xs uppercase tracking-widest" href="#">Arquivos</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
