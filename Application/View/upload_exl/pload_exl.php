<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
</head>
<body>
<input type="file" id="fileInput" />
<button onclick="uploadData()">Upload Data</button>

<script>
    function uploadData() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        if (!file) {
            alert('Please select a file.');
            return;
        }

        var reader = new FileReader();
        reader.onload = function(event) {
            var data = new Uint8Array(event.target.result);
            var workbook = XLSX.read(data, {type: 'array'});
            var sheetName = workbook.SheetNames[0];
            var worksheet = workbook.Sheets[sheetName];
            var json = XLSX.utils.sheet_to_json(worksheet);

            console.log(json)
            document.write( JSON.stringify(json))
            // Envoyer les données au serveur
            fetch('upload.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(json),
            })
                .then(response => response.text())
                .then(result => {
                    alert('Data uploaded successfully.');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
        reader.readAsArrayBuffer(file);
    }
</script>
</body>
</html>
