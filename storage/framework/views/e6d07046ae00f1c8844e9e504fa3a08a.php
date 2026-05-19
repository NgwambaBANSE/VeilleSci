

<?php $__env->startSection('content'); ?>

<style>
    .art-nav { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .art-nav-toggle { display: none; width: 42px; height: 42px; border: none; background: transparent; cursor: pointer; align-items: center; justify-content: center; }
    .art-nav-toggle span { display: block; width: 22px; height: 2px; background: #1a3a5c; border-radius: 999px; position: relative; transition: transform .2s ease, opacity .2s ease; }
    .art-nav-toggle span::before,
    .art-nav-toggle span::after { content: ''; display: block; width: 22px; height: 2px; background: #1a3a5c; border-radius: 999px; position: absolute; left: 0; transition: transform .2s ease, opacity .2s ease; }
    .art-nav-toggle span::before { top: -7px; }
    .art-nav-toggle span::after { top: 7px; }
    .art-mobile-menu { display: none; flex-direction: column; gap: 10px; padding: 16px 24px; background: #fff; border-bottom: 1px solid #e2e8f0; }
    .art-mobile-menu a, .art-mobile-menu button { width: 100%; text-align: left; }
    @media (max-width: 760px) {
        .art-nav-links { display: none; width: 100%; }
        .art-nav-toggle { display: inline-flex; }
    }
</style>


<div class="topbar"> Portail National de Veille Scientifique — Burkina Faso</div>


<nav class="art-nav">
    <a href="/" class="art-logo">
        <div class="art-logo-icon">🔬</div>
        <div>
            <div class="art-logo-title">VeilleSci <span>BF</span></div>
            <div class="art-logo-sub">Portail de Veille Scientifique</div>
        </div>
    </a>
    <div class="art-nav-links">
        <a href="/app"    class="art-btn art-btn-outline">📋 Opportunités</a>
        <a href="/forum"  class="art-btn art-btn-outline">💬 Forum</a>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('profile.show')); ?>" class="art-btn art-btn-outline">👤 Profil</a>
            <form method="POST" action="/logout" style="margin:0;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="art-btn art-btn-outline">🚪 Déconnexion</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>"    class="art-btn art-btn-outline">Se connecter</a>
            <a href="<?php echo e(route('register')); ?>" class="art-btn art-btn-green">Créer un compte</a>
        <?php endif; ?>
    </div>
    <button class="art-nav-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <span aria-hidden="true"></span>
    </button>
</nav>
<div class="art-mobile-menu" aria-hidden="true">
    <a href="/app" class="art-btn art-btn-outline">📋 Opportunités</a>
    <a href="/forum" class="art-btn art-btn-outline">💬 Forum</a>
    <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('profile.show')); ?>" class="art-btn art-btn-outline">👤 Profil</a>
        <form method="POST" action="/logout" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="art-btn art-btn-outline" style="width:100%; text-align:left;">🚪 Déconnexion</button>
        </form>
    <?php else: ?>
        <a href="<?php echo e(route('login')); ?>"    class="art-btn art-btn-outline">Se connecter</a>
        <a href="<?php echo e(route('register')); ?>" class="art-btn art-btn-green">Créer un compte</a>
    <?php endif; ?>
</div>


<div class="art-banner">
    <div class="art-banner-inner">
        <div>
            <div class="art-banner-badge">📚 Veille scientifique automatisée</div>
            <h1>Articles scientifiques<br/>résumés par <span>Intelligence Artificielle</span></h1>
            <p>Explorez les dernières publications, consultez des résumés intelligents et restez à la pointe de la recherche africaine.</p>
            <div class="art-banner-btns">
                <a href="<?php echo e(route('articles.index')); ?>" class="art-cta-primary">Découvrir les articles →</a>
                <a href="/forum" class="art-cta-secondary">💬 Visiter le forum</a>
            </div>
        </div>
        <div class="art-banner-stats">
            <div>
                <div class="art-bstat-num"><?php echo e($articles->total()); ?></div>
                <div class="art-bstat-label">Articles indexés</div>
            </div>
            <div>
                <div class="art-bstat-num"><?php echo e(count($domaines)); ?></div>
                <div class="art-bstat-label">Domaines couverts</div>
            </div>
        </div>
    </div>
</div>


<div class="art-main">

    <div>
        
        <?php if (isset($component)) { $__componentOriginal70b62befa18a98249ae214f5b79034e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70b62befa18a98249ae214f5b79034e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.article-filters','data' => ['domaines' => $domaines,'search' => request('search'),'domaine' => request('domaine')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('article-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['domaines' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($domaines),'search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search')),'domaine' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('domaine'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70b62befa18a98249ae214f5b79034e7)): ?>
<?php $attributes = $__attributesOriginal70b62befa18a98249ae214f5b79034e7; ?>
<?php unset($__attributesOriginal70b62befa18a98249ae214f5b79034e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70b62befa18a98249ae214f5b79034e7)): ?>
<?php $component = $__componentOriginal70b62befa18a98249ae214f5b79034e7; ?>
<?php unset($__componentOriginal70b62befa18a98249ae214f5b79034e7); ?>
<?php endif; ?>

        
        <?php if(session('message')): ?>
            <div class="art-alert">✅ <?php echo e(session('message')); ?></div>
        <?php endif; ?>

        
        <div style="font-size:13px; color:var(--muted); margin-bottom:14px;">
            <?php echo e($articles->total()); ?> article(s) trouvé(s) — affichage de 6 articles par page.
        </div>

        
        <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginal2ef36d4355cd7834c6b42ce99ba2ff15 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ef36d4355cd7834c6b42ce99ba2ff15 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.article-card','data' => ['article' => $article]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('article-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['article' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ef36d4355cd7834c6b42ce99ba2ff15)): ?>
<?php $attributes = $__attributesOriginal2ef36d4355cd7834c6b42ce99ba2ff15; ?>
<?php unset($__attributesOriginal2ef36d4355cd7834c6b42ce99ba2ff15); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ef36d4355cd7834c6b42ce99ba2ff15)): ?>
<?php $component = $__componentOriginal2ef36d4355cd7834c6b42ce99ba2ff15; ?>
<?php unset($__componentOriginal2ef36d4355cd7834c6b42ce99ba2ff15); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="art-empty">
                <div class="art-empty-icon">📭</div>
                <p style="font-size:15px; font-weight:600; color:#1e293b;">Aucun article trouvé</p>
                <p style="font-size:13px; margin-top:6px;">Essayez de modifier vos filtres de recherche.</p>
            </div>
        <?php endif; ?>

        
        <?php echo e($articles->withQueryString()->links('components.pagination')); ?>

    </div>

    
    <?php if (isset($component)) { $__componentOriginal2ab1f20f498f238889d3421c4b1b06a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ab1f20f498f238889d3421c4b1b06a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.article-sidebar','data' => ['articles' => $articles,'stats' => $stats,'domaines' => $domaines,'resumeIaCount' => $resumeIaCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('article-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['articles' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($articles),'stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats),'domaines' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($domaines),'resumeIaCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($resumeIaCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ab1f20f498f238889d3421c4b1b06a5)): ?>
<?php $attributes = $__attributesOriginal2ab1f20f498f238889d3421c4b1b06a5; ?>
<?php unset($__attributesOriginal2ab1f20f498f238889d3421c4b1b06a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ab1f20f498f238889d3421c4b1b06a5)): ?>
<?php $component = $__componentOriginal2ab1f20f498f238889d3421c4b1b06a5; ?>
<?php unset($__componentOriginal2ab1f20f498f238889d3421c4b1b06a5); ?>
<?php endif; ?>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.art-nav-toggle');
        const menu = document.querySelector('.art-mobile-menu');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            const isOpen = menu.style.display === 'flex';
            menu.style.display = isOpen ? 'none' : 'flex';
            toggle.classList.toggle('active', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
            menu.setAttribute('aria-hidden', String(isOpen));
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\VeilleSci\resources\views/articles/index.blade.php ENDPATH**/ ?>