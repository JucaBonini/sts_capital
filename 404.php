<?php get_header(); ?>

<main id="primary" class="site-main container">

    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">Página não encontrada</h1>
        </header>

        <div class="page-content">
            <p>Parece que nada foi encontrado neste local. Tente uma busca ou volte para a home.</p>
            <?php get_search_form(); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">Voltar para a Home</a>
        </div>
    </section>

</main>

<style>
.error-404 {
    text-align: center;
    padding: 100px 0;
}
.page-title {
    font-size: 3rem;
    color: var(--secondary-color);
}
.page-content {
    max-width: 600px;
    margin: 0 auto;
}
.btn {
    display: inline-block;
    margin-top: 30px;
    background: var(--primary-color);
    color: #fff;
    padding: 12px 25px;
    border-radius: 4px;
    font-weight: 700;
}
</style>

<?php get_footer(); ?>
