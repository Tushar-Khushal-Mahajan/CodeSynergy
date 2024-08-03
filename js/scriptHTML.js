document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('textarea').forEach(textarea => {
      textarea.addEventListener('input', () => {
        hljs.highlightBlock(textarea);
      });
    });
  
    loadFiles();
  });
  
  function saveFile() {
    const htmlCode = document.getElementById('htmlCode').value;
    const cssCode = document.getElementById('cssCode').value;
    const jsCode = document.getElementById('jsCode').value;
  
    const fileName = prompt("Enter file name:");
    if (fileName) {
      const fileContent = { html: htmlCode, css: cssCode, js: jsCode };
      localStorage.setItem(fileName, JSON.stringify(fileContent));
      loadFiles();
    }
  }
  
  function loadFiles() {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
  
    for (let i = 0; i < localStorage.length; i++) {
      const fileName = localStorage.key(i);
      const fileItem = document.createElement('a');
      fileItem.className = 'list-group-item list-group-item-action';
      fileItem.href = '#';
      fileItem.innerHTML = `
        ${fileName}
        <button class="delete-button" onclick="deleteFile('${fileName}')"><i class="fas fa-trash"></i></button>
      `;
      fileItem.onclick = () => loadFile(fileName);
      fileList.appendChild(fileItem);
    }
  }
  
  function loadFile(fileName) {
    const fileContent = JSON.parse(localStorage.getItem(fileName));
    document.getElementById('htmlCode').value = fileContent.html;
    document.getElementById('cssCode').value = fileContent.css;
    document.getElementById('jsCode').value = fileContent.js;
  
    document.querySelectorAll('textarea').forEach(textarea => {
      hljs.highlightBlock(textarea);
    });
  }
  
  function deleteFile(fileName) {
    localStorage.removeItem(fileName);
    loadFiles();
  }
  
  function searchFiles() {
    const searchValue = document.getElementById('searchFiles').value.toLowerCase();
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
  
    for (let i = 0; i < localStorage.length; i++) {
      const fileName = localStorage.key(i).toLowerCase();
      if (fileName.includes(searchValue)) {
        const fileItem = document.createElement('a');
        fileItem.className = 'list-group-item list-group-item-action';
        fileItem.href = '#';
        fileItem.innerHTML = `
          ${localStorage.key(i)}
          <button class="delete-button" onclick="deleteFile('${localStorage.key(i)}')"><i class="fas fa-trash"></i></button>
        `;
        fileItem.onclick = () => loadFile(localStorage.key(i));
        fileList.appendChild(fileItem);
      }
    }
  }
  
  function runCode() {
    const htmlCode = document.getElementById('htmlCode').value;
    const cssCode = document.getElementById('cssCode').value;
    const jsCode = document.getElementById('jsCode').value;
  
    const outputFrame = document.getElementById('outputFrame');
    const outputContent = `
      <html>
      <head>
        <style>${cssCode}</style>
      </head>
      <body>
        ${htmlCode}
        <script>${jsCode}<\/script>
      </body>
      </html>
    `;
  
    outputFrame.srcdoc = outputContent;
    $('#outputModal').modal('show');
  }
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
      hljs.highlightBlock(block);
    });
  });
  