<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="Customer account pagination">
    <ul class="pagination justify-content-center mb-0">

        <?php if ($pager->hasPreviousPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>">
                    First
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>">
                    Previous
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a
                    class="page-link"
                    href="<?= $link['uri'] ?>"
                    <?= $link['active'] ? 'aria-current="page"' : '' ?>
                >
                    <?= esc($link['title']) ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage() ?>">
                    Next
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">
                    Last
                </a>
            </li>
        <?php endif ?>

    </ul>
</nav>