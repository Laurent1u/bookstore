<div class="row justify-content-center">
    <div class="col-sm-8 mb-5">
        <?php
        if ($result) {
            echo "<p class='bg-success text-white text-center'>" . $result . "</p>";
        }
        ?>
        <form method="post" action="#">
            <input type="hidden" name="doAction" value="">
            <input type="hidden" name="author_id" value="<?php echo $edit->id ?? null; ?>">
            <div class="form-group">
                <label for="author_name">Nume Autor</label>
                <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo $edit->name ?? null; ?>" placeholder="Nume Autor">
            </div>
            <button type="submit" class="btn btn-secondary btn-sm">Salveaza</button>
        </form>
    </div>
    <div class="col-sm-8">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nume</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($list) {
                    foreach ($list as $author) { ?>
                        <tr>
                            <th scope="row"><?php echo $author->id; ?></th>
                            <td><?php echo $author->name; ?></td>
                            <td>
                                <a href="?p=add_author&doAction=edit&author_id=<?php echo $author->id; ?>"><i
                                            class="fas fa-edit"></i></a>
                                <a href="?p=add_author&doAction=delete&author_id=<?php echo $author->id; ?>"
                                   class="text-danger"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        $('form').submit(function (e) {
            e.preventDefault();
            let authorName = $('#author_name');

            if (isEmpty(authorName.val())) {
                authorName.removeClass('is-valid').addClass('is-invalid');
                alert('Autorul este camp obligatoriu !');
                return false;
            } else if (authorName.val().length <= 4) {
                authorName.removeClass('is-valid').addClass('is-invalid');
                alert('Numele este prea scurt !');
                return false;
            }
            authorName.removeClass('is-invalid').addClass('is-valid');
            this.elements['doAction'].value = 'save';
            this.submit();
        });
    }
</script>