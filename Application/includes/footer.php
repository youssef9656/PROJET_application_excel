<script>
    keepDatalistOptions('.keepDatalist');
    function keepDatalistOptions(selector = '') {
        // select all input fields by datalist attribute or by class/id
        selector = !selector ? "input[list]" : selector;
        let datalistInputs = document.querySelectorAll(selector);
        if (datalistInputs.length) {
            for (let i = 0; i < datalistInputs.length; i++) {
            let input = datalistInputs[i];
            input.addEventListener("input", function(e) {
                e.target.setAttribute("placeholder", e.target.value);
                e.target.blur();
            });
            input.addEventListener("focus", function(e) {
                e.target.setAttribute("placeholder", e.target.value);
                e.target.value = "";
            });
            input.addEventListener("blur", function(e) {
                e.target.value = e.target.getAttribute("placeholder");
            });
            }
        }
    }
</script>
<?php
$conn->close();
?>