<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['article', 'userId' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['article', 'userId' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="art-card">
    
    <div class="art-card-top">
        <div class="art-card-meta">
            <?php if($article->domaine): ?>
                <?php if (isset($component)) { $__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.article-badge','data' => ['label' => $article->domaine,'type' => 'domain']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('article-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->domaine),'type' => 'domain']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480)): ?>
<?php $attributes = $__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480; ?>
<?php unset($__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480)): ?>
<?php $component = $__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480; ?>
<?php unset($__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if($article->mots_cles): ?>
                <?php $__currentLoopData = array_slice(explode(',', $article->mots_cles), 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.article-badge','data' => ['label' => trim($mot),'type' => 'keyword']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('article-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trim($mot)),'type' => 'keyword']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480)): ?>
<?php $attributes = $__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480; ?>
<?php unset($__attributesOriginald5a3c2990fbcb5778f34c12e8cd6a480); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480)): ?>
<?php $component = $__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480; ?>
<?php unset($__componentOriginald5a3c2990fbcb5778f34c12e8cd6a480); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <a href="<?php echo e(route('articles.show', $article)); ?>" class="art-card-title">
            <?php echo e($article->titre); ?>

        </a>

        <p class="art-card-authors">
            ✍️ <?php echo e($article->auteurs ?: 'Auteurs inconnus'); ?>

        </p>
        <p class="art-card-info">
            📅 <?php echo e($article->date_publication?->format('d/m/Y') ?? 'Date inconnue'); ?>

            <?php if($article->journal): ?> · 📖 <?php echo e($article->journal); ?> <?php endif; ?>
        </p>
    </div>

    
    <?php if($article->resume_ia): ?>
        <div class="art-resume art-resume-ia">
            <div class="art-resume-label">🤖 Résumé IA</div>
            <?php echo e($article->resume_ia); ?>

        </div>
    <?php elseif($article->resume): ?>
        <div class="art-resume art-resume-std">
            <div class="art-resume-label">📄 Résumé</div>
            <?php echo e(Str::limit($article->resume, 250)); ?>

        </div>
    <?php endif; ?>

    
    <div class="art-card-footer">
        <a href="<?php echo e(route('articles.show', $article)); ?>" class="art-footer-primary">
            Lire l'article →
        </a>
        <?php if($article->doi): ?>
            <a href="https://doi.org/<?php echo e($article->doi); ?>" target="_blank" rel="noopener"
               class="art-footer-secondary">DOI</a>
        <?php endif; ?>
        <?php if($article->url): ?>
            <a href="<?php echo e($article->url); ?>" target="_blank" rel="noopener"
               class="art-footer-secondary">Lien direct</a>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
            <?php if($article->isFavoriBy(Auth::id())): ?>
                <form method="POST" action="<?php echo e(route('articles.favori.remove', $article)); ?>"
                      style="margin:0; margin-left:auto;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="art-favori" title="Retirer des favoris">❤️</button>
                </form>
            <?php else: ?>
                <form method="POST" action="<?php echo e(route('articles.favori.add', $article)); ?>"
                      style="margin:0; margin-left:auto;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="art-favori" title="Ajouter aux favoris">🤍</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="art-favori" style="margin-left:auto; text-decoration:none;"
               title="Connectez-vous pour ajouter aux favoris">🤍</a>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\VeilleSci\resources\views/components/article-card.blade.php ENDPATH**/ ?>