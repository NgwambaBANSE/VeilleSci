<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['articles', 'stats' => [], 'domaines' => [], 'resumeIaCount' => 0]));

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

foreach (array_filter((['articles', 'stats' => [], 'domaines' => [], 'resumeIaCount' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div>
    
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">📊 Statistiques</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            <div class="art-stat-row">
                <span>Total articles</span>
                <span class="art-stat-val"><?php echo e($articles->total()); ?></span>
            </div>
            <div class="art-stat-row">
                <span>Avec résumé IA</span>
                <span class="art-stat-val" style="color:var(--green);">
                    <?php echo e($resumeIaCount); ?>

                </span>
            </div>
            <div class="art-stat-row">
                <span>Domaines</span>
                <span class="art-stat-val"><?php echo e(count($domaines)); ?></span>
            </div>
        </div>
    </div>

    
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">📂 Domaines</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            <?php $__currentLoopData = $domaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('articles.index', ['domaine' => $dom])); ?>" class="art-domain-item">
                    <span><?php echo e(ucfirst($dom)); ?></span>
                    <span class="art-domain-count">
                        <?php echo e($stats[$dom] ?? 0); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">🔗 Navigation rapide</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            <a href="/app"   class="art-domain-item">📋 Opportunités</a>
            <a href="/forum" class="art-domain-item">💬 Forum</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('profile.show')); ?>" class="art-domain-item">👤 Mon profil</a>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="art-domain-item">🚀 Créer un compte</a>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="art-sidebar-card" style="overflow:visible;">
        <div class="art-sidebar-head">💡 Le saviez-vous ?</div>
        <div class="art-sidebar-body" style="font-size:13px; color:var(--muted); line-height:1.7;">
            Les résumés <strong style="color:var(--green);">🤖 IA</strong> sont générés automatiquement par Claude pour vous faire gagner du temps dans votre veille scientifique.
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\VeilleSci\resources\views/components/article-sidebar.blade.php ENDPATH**/ ?>