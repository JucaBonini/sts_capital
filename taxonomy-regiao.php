<?php get_header(); 
$term = get_queried_object();
$parent = ($term->parent != 0) ? get_term($term->parent, 'regiao') : false;
?>

<main class="pt-32 pb-20 max-w-screen-2xl mx-auto px-8">
    
    <!-- Breadcrumbs -->
    <div class="mb-8">
        <?php sts_capital_breadcrumbs(); ?>
    </div>
    
    <header class="mb-16 max-w-4xl border-l-4 border-primary pl-8">
        <span class="text-primary font-label text-xs uppercase tracking-[0.2em] mb-4 block font-bold">
            <?php echo $parent ? 'Cidades em ' . $parent->name : 'Estados atendidos'; ?>
        </span>
        <h1 class="text-5xl md:text-6xl font-headline font-black tracking-tighter text-on-surface mb-6 leading-none">
            Instaladores Solares em<br><span class="text-primary"><?php echo $term->name; ?>.</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
            <?php 
            if ($term->description) {
                echo $term->description;
            } else {
                echo "Conheça as empresas de energia solar e instaladores certificados que atendem a região de " . $term->name . ". Profissionais qualificados para projetos residenciais e comerciais.";
            }
            ?>
        </p>
    </header>

    <!-- Listagem -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', 'instalador-card' ); ?>
        <?php endwhile; else : ?>
            <p>Nenhum instalador encontrado nesta região ainda.</p>
        <?php endif; ?>
    </div>

</main>

<?php get_footer(); ?>
