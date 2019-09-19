<div class="row mb-5">
    <div class="col">
        <?php
        if ($result->message) {
            echo "<p class='bg-success text-white text-center'>" . $result->message . "</p>";
        }
        ?>
        <form method="post" action="" class="form-row" id="saveForm">
            <input type="hidden" name="p" value="<?php echo $page; ?>">
            <input type="hidden" name="doAction" value="">
            <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
            <input type="hidden" name="loan_id" value="<?php echo $loanId; ?>">

            <?php if ($bookId || $loanId) { ?>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Nume Carte:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->book_name; ?>" disabled>
                </div>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Autor:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->authors_name; ?>" disabled>
                </div>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Editura:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->publisher; ?>" disabled>
                </div>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Data Aparitiei:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->appearance_date; ?>" disabled>
                </div>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Numar Pagini:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->page_number; ?>" disabled>
                </div>
                <div class="form-group input-group-sm col-sm-4">
                    <label for="name">Cod De Bare:</label>
                    <input type="text" class="form-control" value="<?php echo $booksList[0]->bar_code; ?>" disabled>
                </div>
            <?php } else { ?>
            <div class="form-group col-sm-6">
                <label for="loan_book_id">Carti:</label>
                <select name="loan_book_id" id="loan_book_id" class="custom-select custom-select-sm" onchange="this.form.submit();">
                    <option value="">Tot</option>
                    <?php foreach ($booksList as $book) { ?>
                        <option value="<?php echo $book->id ?>" <?php if ($loanBookId == $book->id) { echo ' selected';} ?>><?php echo $book->name; ?></option>
                    <?php } ?>
                </select>
            </div>
                <div class="form-group col-sm-6">
                    <label for="loan_publisher_id">Editura:</label>
                    <select name="loan_publisher_id" id="loan_publisher_id" class="custom-select custom-select-sm" onchange="this.form.submit();">
                        <option value="">Tot</option>
                        <?php foreach ($publisherList as $publisher) { ?>
                            <option value="<?php echo $publisher->id ?>" <?php if ($loanPublisherId == $publisher->id) { echo ' selected';} ?>><?php echo $publisher->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="form-group col-sm-4">
                <label for="name">Nume:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $loanId ? $booksList[0]->name : ''; ?>">
            </div>
            <div class="form-group col-sm-4">
                <label for="surname">Prenume:</label>
                <input type="text" class="form-control" name="surname" id="surname" value="<?php echo $booksList[0]->surname; ?>">
            </div>
            <div class="form-group col-sm-2">
                <label for="loan_days">Zile Imprumut:</label>
                <input type="number" class="form-control" name="loan_days" id="loan_days" value="<?php echo $booksList[0]->days_loan; ?>" autocomplete="off">
            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-secondary btn-sm">Salveaza</button>
            </div>
        </form>
    </div>
</div>

<form action="?p=book_loan" method="get" id="searchForm">
    <table class="table">
        <thead>
            <tr>
                <th colspan="6">
                    <div class="form-group">
                        <label for="loan_book">Carti Imprumutate:</label>
                        <select name="loan_book" id="loan_book" class="custom-select custom-select-sm">
                            <option value="">Tot</option>
                            <?php foreach ($takenBooks as $book) { ?>
                                <option value="<?php echo $book->id ?>"><?php echo $book->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </th>
                <th>
                    <div class="form-group">
                        <label for="loan_exceeded">Termen Depasit:</label>
                        <select name="loan_exceeded" id="loan_exceeded" class="custom-select custom-select-sm">
                            <option value="">Tot</option>
                        </select>
                    </div>
                </th>
                <th>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-sm">Cauta</button>
                    </div>
                </th>
            </tr>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nume</th>
                <th scope="col">Prenume</th>
                <th scope="col">Carte</th>
                <th scope="col">Editura</th>
                <th scope="col">Returnare Carte</th>
                <th scope="col" colspan="2">Nr Zile Imprumut</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($bookLoansList) { ?>
            <?php foreach ($bookLoansList as $loan) { ?>
                <tr>
                    <th scope="row"><?php echo $loan->id; ?></th>
                    <th><?php echo $loan->name; ?></th>
                    <td><?php echo $loan->surname; ?></td>
                    <td><?php echo $loan->book_name; ?></td>
                    <td><?php echo $loan->publisher; ?></td>
                    <td><?php echo $loan->return_date; ?></td>
                    <td><?php echo $loan->days_loan; ?></td>
                    <td>
                        <a href="?p=book_loan&loan_id=<?php echo $loan->id; ?>"><i class="fas fa-edit"></i></a>
                        <a href="?p=book_loan&doAction=delete&loan_id=<?php echo $loan->id; ?>&book_id=<?php echo $loan->book_id; ?>"
                           class="text-danger"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php
            }
        } else { ?>
            <tr><td colspan="8" class="text-center">Nu exista carti imprumutate !</td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<script type="text/javascript">
    window.onload = function () {
        $('form').submit(function (e) {
            e.preventDefault();
            message = [];

            let validate = false;
            let submitForm = true;
            let loanBookId = $('#loan_book_id');
            let loanPublisherId = $('#loan_publisher_id');
            let clientName = $('#name');
            let clientSurname = $('#surname');
            let daysLoan = $('#loan_days');

            if (this.id === 'saveForm') {
                let requiredFields = [clientName, clientSurname, daysLoan];

                if (loanBookId.length) {requiredFields.push(loanBookId)}
                if (loanPublisherId.length) {requiredFields.push(loanPublisherId)}

                requiredFields.forEach((field, index)=> {
                    let labelIdentifier = $('label[for="' + field[0].id + '"]').html();
                    validate = validateEmptyInput(field, labelIdentifier);
                    if (validate.isValid) {
                        submitForm = false;
                    }
                });
                console.log(requiredFields);


                this.elements['doAction'].value = 'save';
            }
            if (!submitForm) {
                alert(validate.message.join().replace(/,/gi, ''));
                return false;
            }
            
            return false;
            submitForm(this);
        });

        function submitForm(formData, send = true) {
            if (send) {
              formData.submit();
            }
        }
    }
</script>