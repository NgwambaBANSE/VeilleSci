<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="art-pagination">
        <div class="flex gap-2 items-center justify-between">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="art-btn art-btn-outline" style="opacity: 0.5; cursor: not-allowed;">
                    ← Précédent
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="art-btn art-btn-outline">
                    ← Précédent
                </a>
            <?php endif; ?>

            
            <div class="flex gap-1">
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_string($element)): ?>
                        <span class="art-btn art-btn-outline" style="opacity: 0.5;"><?php echo e($element); ?></span>
                    <?php endif; ?>

                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span class="art-btn" style="background: var(--green); color: #fff;">
                                    <?php echo e($page); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="art-btn art-btn-outline">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="art-btn art-btn-outline">
                    Suivant →
                </a>
            <?php else: ?>
                <span class="art-btn art-btn-outline" style="opacity: 0.5; cursor: not-allowed;">
                    Suivant →
                </span>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\VeilleSci\resources\views/components/pagination.blade.php ENDPATH**/ ?>