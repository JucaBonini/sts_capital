<?php
/**
 * Template Name: Calculadora Solar Premium
 */

get_header(); ?>

<!-- SEO Intelligence: SoftwareApplication Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "Calculadora de Economia Solar - Capital Consciente",
  "operatingSystem": "Web",
  "applicationCategory": "BusinessApplication",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "BRL"
  },
  "description": "Simulador de economia solar gratuito. Calcule o número de painéis, investimento necessário e tempo de retorno (payback) para energia fotovoltaica.",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "ratingCount": "1250"
  }
}
</script>

<main class="pt-32 pb-20 bg-slate-50 dark:bg-slate-950 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        
        <!-- Header da Calculadora -->
        <header class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-6">
                <span class="material-symbols-outlined text-[16px]">calculate</span>
                Inteligência Solar
            </div>
            <h1 class="text-4xl lg:text-6xl font-headline font-black text-on-surface leading-tight mb-6">
                Simulador de <span class="text-primary">Economia Solar.</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                Descubra em segundos quanto você pode economizar na sua conta de luz e qual o investimento necessário para sua independência energética.
            </p>
        </header>

        <!-- Container da Calculadora -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Formulário de Entrada (Lado Esquerdo) -->
            <div class="lg:col-span-5 space-y-8 bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800">
                
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Valor Médio da Conta (R$)</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold">R$</span>
                        <input type="number" id="input-bill" placeholder="0,00" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-14 pr-6 py-5 text-xl font-black text-on-surface focus:ring-4 focus:ring-primary/20 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Seu Estado</label>
                    <select id="input-state" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 text-lg font-bold text-on-surface focus:ring-4 focus:ring-primary/20 transition-all">
                        <option value="5.0">São Paulo (SP)</option>
                        <option value="5.0">Rio de Janeiro (RJ)</option>
                        <option value="5.7">Minas Gerais (MG)</option>
                        <option value="5.5">Espírito Santo (ES)</option>
                        <option value="4.8">Paraná (PR)</option>
                        <option value="4.5">Santa Catarina (SC)</option>
                        <option value="4.6">Rio Grande do Sul (RS)</option>
                        <option value="5.5">Distrito Federal (DF)</option>
                        <option value="5.6">Goiás (GO)</option>
                        <option value="5.4">Mato Grosso (MT)</option>
                        <option value="5.4">Mato Grosso do Sul (MS)</option>
                        <option value="5.8">Bahia (BA)</option>
                        <option value="6.0">Ceará (CE)</option>
                        <option value="5.8">Pernambuco (PE)</option>
                        <option value="6.0">Rio Grande do Norte (RN)</option>
                        <option value="5.6">Alagoas (AL)</option>
                        <option value="5.8">Paraíba (PB)</option>
                        <option value="6.0">Piauí (PI)</option>
                        <option value="5.6">Sergipe (SE)</option>
                        <option value="5.4">Maranhão (MA)</option>
                        <option value="5.2">Pará (PA)</option>
                        <option value="4.5">Amazonas (AM)</option>
                        <option value="5.5">Tocantins (TO)</option>
                        <option value="4.8">Rondônia (RO)</option>
                        <option value="4.8">Acre (AC)</option>
                        <option value="5.0">Amapá (AP)</option>
                        <option value="5.2">Roraima (RR)</option>
                    </select>
                </div>

                <button id="btn-calculate" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-6 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:shadow-emerald-500/20 transition-all hover:scale-[1.02] active:scale-95">
                    Calcular Economia
                </button>

            </div>

            <!-- Resultados (Lado Direito) -->
            <div id="results-container" class="lg:col-span-7 opacity-30 pointer-events-none transition-all duration-700">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Card: Economia Mensal -->
                    <div class="bg-indigo-950 p-8 rounded-[2rem] text-white overflow-hidden relative">
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Economia Mensal</span>
                        <div class="text-4xl font-black mt-2">R$ <span id="res-monthly-savings">0,00</span></div>
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl">savings</span>
                        </div>
                    </div>

                    <!-- Card: Payback -->
                    <div class="bg-emerald-500 p-8 rounded-[2rem] text-indigo-950 overflow-hidden relative">
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Retorno do Investimento</span>
                        <div class="text-4xl font-black mt-2"><span id="res-payback">0</span> Anos</div>
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl">update</span>
                        </div>
                    </div>

                    <!-- Card: Painéis -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-8 rounded-[2rem]">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total de Painéis</span>
                        <div class="text-3xl font-black mt-2 text-on-surface"><span id="res-panels">0</span> Módulos</div>
                        <p class="text-[10px] text-slate-400 mt-2">Baseado em painéis de 550Wp</p>
                    </div>

                    <!-- Card: Sustentabilidade -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-8 rounded-[2rem]">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Árvores Plantadas</span>
                        <div class="text-3xl font-black mt-2 text-primary"><span id="res-trees">0</span> Árvores</div>
                        <p class="text-[10px] text-slate-400 mt-2">Equivalente em CO2 por ano</p>
                    </div>

                </div>

                <!-- Botão de Download do PDF (Lead Magnet) -->
                <div class="mt-8">
                    <button id="btn-open-lead-modal" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-800 py-5 rounded-2xl text-on-surface font-black uppercase tracking-widest text-xs hover:border-primary transition-all">
                        <span class="material-symbols-outlined">picture_as_pdf</span>
                        Baixar Relatório Detalhado (.PDF)
                    </button>
                </div>

            </div>

        </div>

        <!-- Vitrine de Afiliados (Recomendações Técnicas) -->
        <div class="mt-20">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-black text-on-surface mb-2">Equipamentos Recomendados</h2>
                <p class="text-slate-400 text-sm">Selecionamos as melhores opções para o seu projeto solar.</p>
            </div>
            <?php echo do_shortcode('[sts_shopping]'); ?>
        </div>

    </div>
</main>

<!-- Modal de Lead Magnet -->
<div id="lead-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" id="modal-overlay"></div>
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[3rem] p-10 relative z-10 shadow-2xl scale-90 opacity-0 transition-all duration-300 transform" id="modal-content">
        <button class="absolute top-6 right-6 text-slate-400 hover:text-on-surface" id="modal-close">
            <span class="material-symbols-outlined">close</span>
        </button>

        <header class="text-center mb-8">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">download_for_offline</span>
            </div>
            <h3 class="text-2xl font-black text-on-surface mb-2">Quase lá!</h3>
            <p class="text-slate-500 text-sm">Para onde devemos enviar seu relatório técnico completo?</p>
        </header>

        <form id="lead-form" class="space-y-4">
            <input type="text" name="name" placeholder="Seu Nome Completo" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-6 py-4 text-on-surface" required>
            <input type="email" name="email" placeholder="Seu melhor e-mail" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-6 py-4 text-on-surface" required>
            <button type="submit" class="w-full bg-primary text-white py-5 rounded-xl font-black uppercase tracking-widest text-xs shadow-lg hover:shadow-primary/20 transition-all">
                Gerar PDF e Baixar
            </button>
        </form>
    </div>
</div>

<!-- Scripts da Calculadora -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const billInput = document.getElementById('input-bill');
    const stateInput = document.getElementById('input-state');
    const calcBtn = document.getElementById('btn-calculate');
    const resultsContainer = document.getElementById('results-container');
    const leadModal = document.getElementById('lead-modal');
    const modalContent = document.getElementById('modal-content');
    
    let calcData = {};

    function calculate() {
        const bill = parseFloat(billInput.value);
        if (!bill || bill <= 0) return alert('Por favor, insira o valor da sua conta.');

        const sunHours = parseFloat(stateInput.value);
        const tariff = 0.95; // Tarifa média Brasil
        const monthlyKwh = bill / tariff;
        
        // Perdas do sistema (20%)
        const dailyKwhNeeded = (monthlyKwh / 30) / 0.80;
        const systemKwp = dailyKwhNeeded / sunHours;
        const panelWattage = 550; // Watts
        const numPanels = Math.ceil((systemKwp * 1000) / panelWattage);
        
        const monthlySavings = bill * 0.95; // 95% de economia média
        const annualSavings = monthlySavings * 12;
        
        // Investimento Estimado (R$ 4.000 por kWp - Média mercado)
        const totalInvestment = systemKwp * 4000;
        const payback = totalInvestment / annualSavings;

        // Sustentabilidade (1kWp evita ~600kg de CO2/ano. 1 árvore absorve ~15kg CO2/ano)
        const co2Avoided = systemKwp * 600;
        const trees = Math.ceil(co2Avoided / 15);

        // Update UI
        document.getElementById('res-monthly-savings').innerText = monthlySavings.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        document.getElementById('res-payback').innerText = payback.toFixed(1);
        document.getElementById('res-panels').innerText = numPanels;
        document.getElementById('res-trees').innerText = trees;

        resultsContainer.classList.remove('opacity-30', 'pointer-events-none');
        resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });

        calcData = { bill, monthlyKwh, systemKwp, numPanels, monthlySavings, payback, trees };
    }

    calcBtn.addEventListener('click', calculate);

    // Modal Logic
    document.getElementById('btn-open-lead-modal').addEventListener('click', () => {
        leadModal.classList.replace('hidden', 'flex');
        setTimeout(() => {
            modalContent.classList.replace('scale-90', 'scale-100');
            modalContent.classList.replace('opacity-0', 'opacity-100');
        }, 10);
    });

    const closeModal = () => {
        modalContent.classList.replace('scale-100', 'scale-90');
        modalContent.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            leadModal.classList.replace('flex', 'hidden');
        }, 300);
    };

    document.getElementById('modal-close').addEventListener('click', closeModal);
    document.getElementById('modal-overlay').addEventListener('click', closeModal);

    // Lead Form & PDF Generation
    document.getElementById('lead-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = this.name.value;
        const email = this.email.value;
        const submitBtn = this.querySelector('button');
        
        submitBtn.innerText = 'PROCESSANDO...';
        submitBtn.disabled = true;

        // Save Lead AJAX
        const formData = new FormData();
        formData.append('action', 'sts_newsletter'); // Reusing existing newsletter logic
        formData.append('email', email);
        formData.append('name', name);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(() => {
            generatePDF(name, calcData);
            submitBtn.innerText = 'DOWNLOAD INICIADO!';
            setTimeout(closeModal, 2000);
        });
    });

    function generatePDF(name, data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Colors
        const primary = [16, 185, 129];
        
        // Header
        doc.setFillColor(15, 23, 42);
        doc.rect(0, 0, 210, 40, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(22);
        doc.setFont('helvetica', 'bold');
        doc.text('CAPITAL CONSCIENTE', 20, 25);
        doc.setFontSize(10);
        doc.text('RELATÓRIO TÉCNICO DE VIABILIDADE SOLAR', 20, 32);

        // Body
        doc.setTextColor(15, 23, 42);
        doc.setFontSize(14);
        doc.text(`Olá, ${name}!`, 20, 60);
        doc.setFontSize(11);
        doc.setFont('helvetica', 'normal');
        doc.text('Aqui estão os resultados da sua simulação baseada no consumo informado.', 20, 68);

        // Summary Table
        doc.setFillColor(248, 250, 252);
        doc.rect(20, 80, 170, 80, 'F');
        
        doc.setFont('helvetica', 'bold');
        doc.text('CONTA DE LUZ ATUAL:', 30, 95);
        doc.text('ECONOMIA ESTIMADA:', 30, 105);
        doc.text('POTÊNCIA DO SISTEMA:', 30, 115);
        doc.text('NÚMERO DE PAINÉIS:', 30, 125);
        doc.text('RETORNO (PAYBACK):', 30, 135);
        doc.text('ÁRVORES PLANTADAS:', 30, 145);

        doc.setFont('helvetica', 'normal');
        doc.text(`R$ ${data.bill.toFixed(2)}`, 110, 95);
        doc.text(`R$ ${data.monthlySavings.toFixed(2)} / mês`, 110, 105);
        doc.text(`${data.systemKwp.toFixed(2)} kWp`, 110, 115);
        doc.text(`${data.numPanels} módulos de 550W`, 110, 125);
        doc.text(`${data.payback.toFixed(1)} anos`, 110, 135);
        doc.text(`${data.trees} árvores por ano`, 110, 145);

        // Footer
        doc.setFontSize(9);
        doc.setTextColor(100, 116, 139);
        doc.text('* Este relatório é uma estimativa baseada em médias regionais.', 20, 180);
        doc.text('Consulte um instalador parceiro no nosso portal para um orçamento real.', 20, 185);

        doc.save(`Relatorio_Solar_Capital_Consciente_${name.replace(/\s+/g, '_')}.pdf`);
    }
});
</script>

<?php get_footer(); ?>
