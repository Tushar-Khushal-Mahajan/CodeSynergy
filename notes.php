<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Maker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f0f0f0;
            color: #212529;
        }

        .file-section {
            width: 300px;
            /* Increased width */
            height: 650px;
            border: 1px solid #ced4da;
            overflow-y: auto;
            padding: 5px;
            background-color: #ffffff;
        }

        .file-list {
            max-height: 100%;
            overflow-y: auto;
        }

        .file-list li {
            margin-bottom: 10px;
            background-color: #f8f9fa;
            /* Light gray background */
            border: 1px solid #dee2e6;
            color: #212529;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            /* For tooltip positioning */
            white-space: nowrap;
            /* Prevent wrapping */
            overflow: hidden;
            /* Hide overflow text */
            text-overflow: ellipsis;
            /* Ellipsis for overflow */
            cursor: pointer;
            /* Change cursor to pointer for clickable area */
        }

        .file-list li:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #e9ecef;
            /* Slightly darker gray on hover */
        }

        .file-list .file-name {
            display: inline-block;
            max-width: calc(100% - 60px);
            /* Account for button width */
            vertical-align: middle;
            white-space: nowrap;
            /* Prevent wrapping */
            overflow: hidden;
            /* Hide overflow text */
            text-overflow: ellipsis;
            /* Ellipsis for overflow */
        }

        .file-list .btn-secondary,
        .file-list .btn-danger {
            margin-left: 5px;
        }

        .file-list .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .file-list .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .file-list .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .file-list .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }


        #editor {
            height: 600px;
            border: 1px solid #95999e;
            background-color: #ffffff;
            color: #212529;
        }

        .tox .tox-toolbar,
        .tox .tox-menubar {
            background-color: #f0f0f0 !important;
        }

        .tox .tox-tbtn {
            color: #212529 !important;
        }

        .tox .tox-edit-area__iframe {
            background-color: #ffffff !important;
            color: #212529 !important;
        }

        .tox .tox-statusbar {
            background-color: #f0f0f0 !important;
        }

        .tox .tox-toolbar__primary {
            background-color: #e0e0e0 !important;
        }

        .tox .tox-toolbar__overflow {
            background-color: #f0f0f0 !important;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .file-list .file-name {
            display: inline-block;
            max-width: calc(100% - 60px);
            /* Adjust for button width */
            vertical-align: middle;
            white-space: nowrap;
            /* Prevent wrapping */
            overflow: hidden;
            /* Hide overflow text */
            text-overflow: ellipsis;
            /* Ellipsis for overflow */
        }

        .file-list .file-name:hover {
            overflow: visible;
            /* Ensure full text shows on hover */
            white-space: normal;
            /* Allow wrapping */
            text-overflow: clip;
            /* Remove ellipsis */
        }
    </style>
    <script src="https://cdn.tiny.cloud/1/hui3mkxhaaux1t86ge47kbjgl0vzkk7k1jx1fijlkb1r1k8a/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="file-section">
                    <h4>Saved Files</h4>
                    <ul id="fileList" class="list-group file-list">
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <textarea id="editor"></textarea>
                <button id="saveButton" class="btn btn-primary mt-2">Save</button>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
            height: 671,
            branding: false,
            color_map: [],
            color_picker: false
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            var content = tinymce.get('editor').getContent();
            var filename = prompt('Enter file name:');

            if (filename) {
                localStorage.setItem(filename, content);
                alert('File saved successfully');
                loadFileList(); // Load the file list after saving
            }
        });

        function loadFile(filename) {
            var content = localStorage.getItem(filename);
            if (content) {
                tinymce.get('editor').setContent(content);
            } else {
                alert('Error loading file');
            }
        }

        function loadFileList() {
            var fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            for (var i = 0; i < localStorage.length; i++) {
                var filename = localStorage.key(i);
                var listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
            <span class="file-name" title="${filename}">${filename}</span>
            <span>
                <button class="btn btn-sm btn-secondary" onclick="downloadFile('${filename}')">
                    <i class="fas fa-download"></i>
                </button>
                <button class="btn btn-sm btn-danger ms-2" onclick="deleteFile('${filename}')">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </span>`;
                // Add click event listener to the entire list item
                listItem.addEventListener('click', function() {
                    var fileName = this.querySelector('.file-name').textContent;
                    loadFile(fileName);
                });
                fileList.appendChild(listItem);
            }
        }

        function downloadFile(filename) {
            var content = localStorage.getItem(filename);
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/html;charset=utf-8,' + encodeURIComponent(content));
            element.setAttribute('download', filename + '.html');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }

        function deleteFile(filename) {
            if (confirm('Are you sure you want to delete this file?')) {
                localStorage.removeItem(filename);
                loadFileList(); // Reload the file list after deleting
                alert('File deleted successfully');
            }
        }

        window.onload = loadFileList;
    </script>
</body>

</html>