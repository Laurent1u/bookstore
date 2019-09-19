<div class="row pb-4">
    <form action="" class="form-inline" method="get">
        <input type="hidden" name="p" value="<?php echo $page; ?>">
        <div class="col-sm-12 form-group">
            <div class="input-group">
                <label for="author">Autor:</label>
                <select name="author" id="author" class="custom-select custom-select-sm">
                    <option value="">Tot</option>
                    <?php foreach ($authorsList as $author) { ?>
                        <option value="<?php echo $author->id; ?>" <?php if($author->id == $authorParam) { echo 'selected'; } ?>><?php echo $author->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group input-group-sm input-daterange align-items-center m2" style="width: 350px;">
                <label for="appearance_date">Data Aparitie: </label>
                <input type="text" class="form-control" name="date_start" value="<?php echo $dateStart; ?>" autocomplete="off">
                <div class="input-group-addon">to</div>
                <input type="text" class="form-control" name="date_end" value="<?php echo $dateEnd; ?>" autocomplete="off">
            </div>
            <div class="input-group m-2">
                <label for="publisher">Editura:</label>
                <select name="publisher" id="publisher" class="custom-select custom-select-sm">
                    <option value="">Tot</option>
                    <?php foreach ($publishersList as $publisher) { ?>
                        <option value="<?php echo $publisher->id; ?>" <?php if($publisher->id == $publisherParam) { echo 'selected'; } ?>><?php echo $publisher->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group m-2">
                <label for="publisher">Imprumutata:</label>
                <select name="loan" id="loan" class="custom-select custom-select-sm">
                    <option value="">Tot</option>
                    <option value="1" <?php echo $loan === true ? ' selected' : ''; ?>>Da</option>
                    <option value="0" <?php echo $loan === false ? ' selected' : ''; ?>>Nu</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="button" class="btn btn-primary mx-5 text-right" onclick="this.form.submit();" value="Cauta">
        </div>
    </form>
</div>
<div class="row">
    <div class="card-deck">
        <?php
        if ($results) {
            foreach ($results as $book) {
                ?>
                <div class="col my-2">
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
                            <div class="text-right">
                                <a href="?p=book_loan&book_id=<?php echo $book->id; ?>"><i class="fas fa-cart-plus text-dark"></i></a>
                                <a href="?p=add_book&book_id=<?php echo $book->id; ?>"><i class="fas fa-edit"></i></a>
                                <a href="?p=book_list&doAction=delete&book_id=<?php echo $book->id; ?>"
                                   class="text-danger"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php if (!$results) { ?>
        <div class="col-sm-10">
            <p class="text-center">Nu exista rezultate !</p>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    window.onload = function () {
        $('.input-daterange input').each(function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                weekStart: 1,
                clearBtn: true,
                startDate: 0
            });
        });
    }
</script>