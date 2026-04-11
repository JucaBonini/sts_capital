<?php get_header(); ?>

<main id="primary" class="site-main container">

    <?php 
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); 
    ?>

    <header class="author-header">
        <div class="author-profile-card">
            <div class="author-photo">
                <?php echo get_avatar( $curauth->ID, 150 ); ?>
            </div>
            <div class="author-text">
                <span class="expertise-badge"><?php echo esc_html( get_the_author_meta( 'expertise', $curauth->ID ) ); ?></span>
                <h1><?php echo $curauth->display_name; ?></h1>
                <div class="author-description">
                    <?php echo wpautop( $curauth->description ); ?>
                </div>
                <!-- Example social links - could be extended with custom user meta -->
                <div class="author-meta-links">
                    <span>Especialista em Energia Solar & Transição Energética</span>
                </div>
            </div>
        </div>
    </header>

    <section class="author-posts">
        <h2 class="section-title">Artigos publicados por <?php echo $curauth->first_name; ?></h2>
        
        <div class="news-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="news-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-content">
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <time class="card-date"><?php echo get_the_date(); ?></time>
                    </div>
                </article>
            <?php endwhile; else : ?>
                <p>Nenhum artigo encontrado.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<style>
.author-header {
    padding: 60px 0;
}
.author-profile-card {
    background: var(--secondary-color);
    color: #fff;
    padding: 50px;
    border-radius: 12px;
    display: flex;
    gap: 40px;
    align-items: center;
}
.author-photo img {
    border-radius: 50%;
    border: 5px solid rgba(255,255,255,0.2);
}
.expertise-badge {
    background: var(--primary-color);
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 10px;
    display: inline-block;
}
.author-profile-card h1 {
    color: #fff;
    font-size: 2.5rem;
    margin-bottom: 15px;
}
.author-description {
    font-size: 1.1rem;
    opacity: 0.9;
}
.author-posts {
    padding: 50px 0;
}
.section-title {
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 3px solid var(--primary-color);
    display: inline-block;
}
@media (max-width: 768px) {
    .author-profile-card { flex-direction: column; text-align: center; padding: 30px; }
}
</style>

<?php get_footer(); ?>
