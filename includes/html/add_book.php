<div class="row justify-content-center">
    <div class="col-sm-8">
        <?php
        if ($result) {
            echo "<p class='bg-success text-white text-center'>" . $result . "</p>";
        }
        ?>
        <form method="post" action="#">
            <input type="hidden" name="doAction" value="">
            <div class="form-group">
                <label for="book_name">Nume Carte</label>
                <input type="text" class="form-control" name="book_name" id="book_name" placeholder="Nume Carte">
            </div>
            <div class="form-group">
                <label for="author_id">Autor</label>
                <select multiple class="form-control" name="author_id[]" id="author_id">
                    <?php foreach ($authorList as $author) { ?>
                        <option value="<?php echo $author->id; ?>"><?php echo $author->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="publisher">Editura</label>
                <select class="form-control" name="publisher" id="publisher">
                    <option value="">TOT</option>
                    <?php foreach ($publisherList as $publisher) { ?>
                        <option value="<?php echo $publisher->id; ?>"><?php echo $publisher->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appearance_date">Data Aparitie</label>
                <input type="text" class="form-control datepicker" name="appearance_date" id="appearance_date" placeholder="Exemplu <?php echo date('Y-m-d'); ?>">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="page_number">Numar Pagini</label>
                <input type="number" class="form-control" name="page_number" id="page_number" placeholder="0">
            </div>
            <div class="form-group">
                <label for="page_number">Pret</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="bar_code">Cod De Bare</label>
                <input type="text" class="form-control" name="bar_code" id="bar_code" placeholder="12345678">
            </div>
            <div class="form-group">
                <label for="description">Descriere</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-secondary btn-sm">Salveaza</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            weekStart: 1,
            clearBtn: true,
            startDate: 0
        });

        $('form').submit(function (e) {
            e.preventDefault();

            let foundError = false;
            let bookName = $('#book_name');
            let authorId = $('#author_id');
            let publisher = $('#publisher');
            let appearanceDate = $('#appearance_date');
            let pageNumber = $('#page_number');
            let barCode = $('#bar_code');
            let price = $('#price');

            if (isEmpty(bookName.val())) {
                bookName.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                bookName.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(authorId.val())) {
                authorId.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                authorId.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(publisher.val())) {
                publisher.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                publisher.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(appearanceDate.val())) {
                appearanceDate.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                appearanceDate.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(pageNumber.val())) {
                pageNumber.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                pageNumber.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(barCode.val()) || (!isEmpty(barCode.val()) && !parseInt(barCode.val()))) {
                if (!isEmpty(barCode.val())  && !parseInt(barCode.val())) {
                    alert('Codul de bare trebuie sa contina doar cifre')
                }
                barCode.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                barCode.removeClass('is-invalid').addClass('is-valid');
            }
            if (isEmpty(price.val()) || (!isEmpty(price.val())  && !parseInt(price.val()))) {
                if (!isEmpty(price.val())  && !parseInt(price.val())) {
                    alert('Pretul trebuie sa contina doar cifre')
                }
                price.removeClass('is-valid').addClass('is-invalid');
                foundError = true;
            } else {
                price.removeClass('is-invalid').addClass('is-valid');
            }

            if (foundError) {
                return false;
            }

            this.elements['doAction'].value = 'save';
            this.submit();
        });
    };
</script>