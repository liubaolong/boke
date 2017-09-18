<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
        <title>Simple example - Editor.md examples</title>
        <link rel="stylesheet" href="<?php echo PUBLIC_PATH;?>editor.md/examples/css/style.css" />
        <link rel="stylesheet" href="<?php echo PUBLIC_PATH;?>editor.md/css/editormd.css" />
        
</head>
<body>
	<div id="test-editormd">
         <textarea style="display:none;"></textarea>
    </div>

</body>
</html>
<script src="<?php echo PUBLIC_PATH;?>editor.md/examples/js/jquery.min.js"></script>
        <script src="<?php echo PUBLIC_PATH;?>editor.md/editormd.min.js"></script>
        <script type="text/javascript">
			var testEditor;

            $(function() {
                testEditor = editormd("test-editormd", {
                    width   : "40%",
                    height  : 640,
                    syncScrolling : "single",
                    path    : "<?php echo PUBLIC_PATH;?>editor.md/lib/"
                });
                
                /*
                // or
                testEditor = editormd({
                    id      : "test-editormd",
                    width   : "90%",
                    height  : 640,
                    path    : "../lib/"
                });
                */
            });
        </script>
