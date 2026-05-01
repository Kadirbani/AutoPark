<?php $page = $page ?? ''; ?>

<nav class="navbar">
    <div class="logo">🏎️ <span>Bani</span> <span>Auto</span>Park</div>

    <ul class="nav-links">
        <li>
            <a href="client/voitures.php"
               class="<?= $page === 'home' ? 'active' : '' ?>">
               Catalogue
            </a>
        </li>
        <li>
            <a href="admin/liste.php"
               class="<?= $page === 'liste' ? 'active' : '' ?>">
               Admin
            </a>
        </li>
        <li>
            <a href="admin/formulaire.php"
               class="<?= $page === 'form' ? 'active' : '' ?>">
               + Ajouter
            </a>
        </li>
    </ul>
</nav>
