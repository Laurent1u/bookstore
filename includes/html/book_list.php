<div class="row">
    <div class="card-deck">

        <?php
        if ($results) {
            foreach ($results as $book) {
                ?>
                <div class="col-sm-4 my-2">
                    <div class="card">
                        <img src="<?php echo DIR_IMAGES . ($book->image ?: 'no_photo.jpg'); ?>" class="card-img-top" alt="Image">
                        <div class="card-body text-center p-2">
                            <h4 class="card-title"><?php echo $book->name; ?></h4>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $book->authors_name; ?></h6>
                            <hr>
                            <p class="card-text text-justify text-muted px-4"><?php echo substr($book->description, 0, 110) . '...'; ?></p>
                            <table class="table table-sm text-left w-75 d-inline">
                                <tbody>
                                    <tr>
                                        <td>Cod de Bare</td>
                                        <td><p class="card-text text-muted m-0"><?php echo $book->bar_code; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td>Numar Pagini</td>
                                        <td><p class="card-text text-muted m-0"><?php echo $book->page_number; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td>Data Aparitiei</td>
                                        <td><p class="card-text text-muted m-0"><?php echo $book->appearance_date; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td>Editura</td>
                                        <td><h6 class="card-text"><?php echo $book->publisher; ?></h6></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="text-white"><span class="badge badge-success"><?php echo $book->price . ' ron'; ?></span></h4>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>
</div>