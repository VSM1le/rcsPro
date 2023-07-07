function validateForm(event) {
    var otherInput = document.getElementById('exampleCheck3').value.trim();
    var checkboxes = document.querySelectorAll('.form-check-input:checked');

    if (checkboxes.length === 0 && otherInput === '') {
        alert("Please select at least one checkbox or provide a value in the 'อื่นๆ' input field.");
        event.preventDefault(); // Prevent form submission
    }
}
// Add event listeners to each expandable row
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}
function ready() {
    var rows = document.getElementsByClassName("expandable-row");
    for (var i = 0; i < rows.length; i++) {
        rows[i].addEventListener("click", toggleExtraInfo);
    }
    var extraInfoRows = document.getElementsByClassName("extra-info");
    for (var i = 0; i < extraInfoRows.length; i++) {
        extraInfoRows[i].style.display = "none";
    }
}
function handleCheckbox(checkbox) {
    const checkboxes = document.querySelectorAll('input[name="' + checkbox.name + '"]');
    checkboxes.forEach(function (cb) {
        if (cb !== checkbox) {
            cb.checked = false;
        }
    });
}

// Toggle the visibility of the extra information row
function toggleExtraInfo() {
    var extraInfoRow = this.nextElementSibling;
    if (extraInfoRow.classList.contains("extra-info")) {
        extraInfoRow.style.display = (extraInfoRow.style.display === "table-row") ? "none" : "table-row";
    }
}

// Add a class to the expandable rows to indicate their initial state as collapsed
var expandableRows = document.getElementsByClassName("expandable-row");
for (var i = 0; i < expandableRows.length; i++) {
    expandableRows[i].classList.add("collapsed");
}