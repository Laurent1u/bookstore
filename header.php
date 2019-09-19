<ul class="nav nav-pills justify-content-center">
    <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'book_list' ? ' active' : ''); ?>" href="index.php?p=book_list">Lista Carti</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'add_author' ? ' active' : ''); ?>" href="index.php?p=add_author">Autori</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'add_book' ? ' active' : ''); ?>" href="index.php?p=add_book">Carti</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'book_loan' ? ' active' : ''); ?>" href="index.php?p=book_loan">Imprumuturi</a>
    </li>
</ul>