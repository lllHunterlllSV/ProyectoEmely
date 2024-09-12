<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM archivos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
$archivo = $resultado->fetch_assoc();

if (!$archivo) {
    die('Archivo no encontrado');
}

$ruta_archivo = $archivo['ruta_archivo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Archivo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf_viewer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf_viewer.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        #pdf-container {
            width: 100%;
            height: 600px;
            overflow-y: auto; /* Scroll vertical */
        }
        .pdf-page {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Archivo: <?php echo htmlspecialchars($archivo['nombre_archivo']); ?></h2>
        <?php if ($id == 1): ?>
            <!-- Mostrar en iframe si el id es 1 -->
            <embed src="<?php echo htmlspecialchars($ruta_archivo); ?>#toolbar=0"width="100%" height="600px" style="border: none;"></iframe>
        <?php else: ?>
            <!-- Mostrar en contenedor scrollable para otros archivos -->
            <div id="pdf-container"></div>
        <?php endif; ?>
        <a href="portal.php" class="btn btn-secondary mt-3">Volver al portal</a>
    </div>

    <script>
        const url = '<?php echo $ruta_archivo; ?>';
        const pdfContainer = document.getElementById('pdf-container');
        let pdfDoc = null;

        function renderPage(num) {
            pdfDoc.getPage(num).then(page => {
                const scale = 1.5;
                const viewport = page.getViewport({ scale });
                
                const canvas = document.createElement('canvas');
                canvas.className = 'pdf-page';
                pdfContainer.appendChild(canvas);
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        }

        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                renderPage(pageNum);
            }
        }).catch(error => {
            console.error('Error al cargar el documento PDF: ', error);
        });
    </script>
</body>
</html>
