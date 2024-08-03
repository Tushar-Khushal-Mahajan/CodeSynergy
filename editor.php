<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}
$studentId = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>C Language Editor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.7/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.7/theme/dracula.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for search icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.7/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery for AJAX -->
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-2" id="fileSection">
                <button class="btn btn-primary mb-2" onclick="saveCode()"><b>SAVE FILES</b> <i class="bi bi-floppy2"></i></button>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search files..." id="searchInput" onkeyup="filterFiles()">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div id="fileList" class="list-group"></div>
            </div>
            <div class="col-md-7">
                <h2>Code Editor</h2>
                <div class="btn-group mb-2" role="group">
                    <!-- Character insertion buttons -->
                    <button class="btn btn-secondary" onclick="insertCharacter('{}')">{}</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('%')">%</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('/')">/</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('*')">*</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('+')">+</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('-')">-</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('=')">=</button>
                    <button class="btn btn-secondary" onclick="insertCharacter(',')">,</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('!')">!</button>
                    <button class="btn btn-secondary" onclick="insertCharacter(';')">;</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('.')">.</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('<>')"><></button>
                    <button class="btn btn-secondary" onclick="insertCharacter('>')">></button>
                    <button class="btn btn-secondary" onclick="insertCharacter('#')">#</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('&')">&</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('()')">()</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('[]')">[]</button>
                    <button class="btn btn-secondary" onclick="insertCharacter(':')">:</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('|')">|</button>
                    <button class="btn btn-secondary" onclick="insertCharacter('->')">-></button>
                    <button class="btn btn-secondary" onclick="insertCharacter('?')">?</button>
                </div>
                <button class="btn btn-success mb-2" onclick="sendCode()"><i class="bi bi-send-check-fill"></i></button>
                <button id="runbtn" class="btn btn-primary mb-2" onclick="runCode()">RUN <i class="bi bi-caret-right-square-fill"></i></button>
                <div id="textareacontainer">
                    <textarea id="textareaCode" name="code">
#include <stdio.h>

int main() {
    printf("Hello, World!");
    return 0;
}
                    </textarea>
                    <form id="codeForm" autocomplete="off" style="margin:0px;display:none;">
                        <input type="hidden" name="code" id="code" />
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div id="iframecontainer">
                    <div id="runloadercontainer">
                        <div class="loader"></div> 
                    </div>
                    <div id="iframewrapper">
                        <iframe id="iframeResult" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tryitLeaderboard">
        <div id="adngin-try_it_leaderboard-0"></div>
    </div>
    <div id="shield"></div>
    <a href="javascript:void(0)" id="dragbar"></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> <!-- Font Awesome for search icon -->
    <script src="js/scriptEditor.js"></script>
</body>
</html>

