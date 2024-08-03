<?php
// Ensure the 'codeContent' POST parameter is present
if (isset($_POST['codeContent'])) {
    // Get the code content
    $code = $_POST['codeContent'];

    // Specify the file name for temporary storage
    $tempFile = 'temp_code.c';
    $outputFile = 'output.exe'; // Use .exe extension for Windows

    // Write the code to a temporary file
    file_put_contents($tempFile, $code);

    // Compile the code using gcc (assumes gcc is installed on the server)
    $compileCommand = "gcc $tempFile -o $outputFile 2>&1";
    $compileResult = shell_exec($compileCommand);

    // Check if compilation was successful
    if ($compileResult) {
        echo "<pre>Compilation error:\n$compileResult</pre>";
    } else {
        // Execute the compiled program
        $runCommand = "$outputFile 2>&1"; // Use output.exe for Windows
        $runResult = shell_exec($runCommand);
        
        // Output the result
        echo "<pre>$runResult</pre>";
    }

    // Clean up temporary files
    if (file_exists($tempFile)) {
        unlink($tempFile);
    }
    if (file_exists($outputFile)) {
        unlink($outputFile);
    }
} else {
    echo "No code content received.";
}
?>
