function isEmpty(string) {
    return (!string || string.length === 0);
}

let message = [];
function validateEmptyInput(input, labelName) {
    let foundError = false;
    let response = {};

    input.removeClass('is-invalid').addClass('is-valid');
    if (isEmpty(input.val())) {
        input.removeClass('is-valid').addClass('is-invalid');
        message.push('Campul ' + labelName + ' este gol !\n');
        foundError = true;
    }

    response.isValid = foundError;
    response.message = message;
    return response;
}

function validateIntInput(field, labelName) {
    let foundError = false;
    let response = {};

    if (!field.hasClass('is_invalid')) {field.removeClass('is-invalid').addClass('is-valid');}
    if (!parseInt(field.val())) {
        field.removeClass('is-valid').addClass('is-invalid');
        message.push('Campul ' + labelName + ' trebuie sa contina doar cifre !\n');
        foundError = true;
    }

    response.isValid = foundError;
    response.message = message;
    return response;
}

function validateLengthInput(field, labelName, minLength = 4) {
    let foundError = false;
    let response = {};

    if (!field.hasClass('is_invalid')) {field.removeClass('is-invalid').addClass('is-valid');}
    if (field.val().length < minLength) {
        field.removeClass('is-valid').addClass('is-invalid');
        message.push('Campul ' + labelName + ' trebuie sa contina minim '+ minLength +' caractere !\n');
        foundError = true;
    }

    response.isValid = foundError;
    response.message = message;
    return response;
}