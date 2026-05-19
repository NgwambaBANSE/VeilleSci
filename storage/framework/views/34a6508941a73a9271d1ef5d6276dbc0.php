<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['domaines', 'search' => '', 'domaine' => '']));

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

foreach (array_filter((['domaines', 'search' => '', 'domaine' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="art-filters">
    <form method="GET" action="<?php echo e(route('articles.index')); ?>">
        <div class="art-field">
            <label>🔍 Recherche</label>
            <input type="text" name="search" value="<?php echo e($search); ?>"
                   placeholder="Titre, auteur, mot-clé..." />
        </div>
        <div class="art-field">
            <label>📚 Domaine</label>
            <select name="domaine">
                <option value="">Tous les domaines</option>
                <?php $__currentLoopData = $domaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dom); ?>" <?php echo e($domaine === $dom ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($dom)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div style="display:flex; align-items:flex-end;">
            <button type="submit" class="art-btn art-btn-green" style="padding:9px 20px; font-size:13px;">
                Filtrer
            </button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\VeilleSci\resources\views/components/article-filters.blade.php ENDPATH**/ ?>