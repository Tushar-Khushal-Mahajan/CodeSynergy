   let editor;

    document.addEventListener("DOMContentLoaded", function() {
        editor = CodeMirror.fromTextArea(document.getElementById("textareaCode"), {
            lineNumbers: true,
            mode: "text/x-csrc",
            theme: "dracula",
        });
        loadFiles(); // Load files on page load
    });

    function saveCode() {
        const codeContent = editor.getValue();
        const fileName = prompt('Enter file name');
        if (fileName) {
            fetch('insert.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'fileName': fileName,
                    'codeContent': codeContent
                })
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    alert('File saved successfully.');
                    loadFiles();
                } else {
                    alert('Error saving file.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function loadFiles() {
        fetch('fetch_files.php')
            .then(response => response.json())
            .then(files => {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';
                files.forEach(file => {
                    const listItem = document.createElement('div');
                    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                    listItem.innerHTML = `
                        <span class="file-name" onclick="openFile('${file}')">${file}</span>
                        <div>
                            <button class="btn btn-danger btn-sm ml-2" onclick="deleteFile('${file}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                    fileList.appendChild(listItem);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function filterFiles() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('#fileList .list-group-item');
        items.forEach(item => {
            const fileName = item.querySelector('.file-name').textContent.toLowerCase();
            item.style.display = fileName.includes(query) ? 'block' : 'none';
        });
    }

    function openFile(fileName) {
        fetch('fetch_files.php', {  
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'fileName': fileName
            })
        })
        .then(response => response.text())
        .then(codeContent => {
            editor.setValue(codeContent);
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteFile(fileName) {
    if (confirm(`Are you sure you want to delete ${fileName}?`)) {
        fetch('delete_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'action': 'delete',
                'fileName': fileName
            })
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                alert('File deleted successfully.');
                loadFiles();
            } else {
                alert('Error deleting file: ' + result);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


function sendCode() {
    const codeContent = editor.getValue();
    const outputContent = ''; 

    if (!codeContent) {
        alert('Please enter some code before sending.');
        return;
    }

    // Save the code before sending
    saveCodeAndRedirect(codeContent, outputContent);
}

function saveCodeAndRedirect(codeContent, outputContent) {
    const fileName = prompt('Enter file name to save before sending');
    if (fileName) {
        fetch('insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'fileName': fileName,
                'codeContent': codeContent
            })
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                alert('File saved successfully.');
                const encodedCode = encodeURIComponent(codeContent);
                const encodedOutput = encodeURIComponent(outputContent);
                window.location.href = `result.php?code=${encodedCode}&output=${encodedOutput}`;
            } else {
                alert('Error saving file.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}


    function runCode() {
        document.getElementById('runloadercontainer').style.display = 'block';
        const codeContent = editor.getValue();
        fetch('run_code.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'codeContent': codeContent
            })
        })
        .then(response => response.text())
        .then(result => {
            document.getElementById('iframeResult').contentDocument.open();
            document.getElementById('iframeResult').contentDocument.write(result);
            document.getElementById('iframeResult').contentDocument.close();
            document.getElementById('runloadercontainer').style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('runloadercontainer').style.display = 'none';
        });
    }

    function insertCharacter(char) {
        const doc = editor.getDoc();
        const cursor = doc.getCursor();
        doc.replaceRange(char, cursor);
    }