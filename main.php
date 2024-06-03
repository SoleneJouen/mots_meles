<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Page de test grille</title>
</head>
<body>
 
    <style>
 
        table,tr,td
        {
            border: black solid 2px;
            border-collapse: collapse;
        }
 
        table
        {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
 
        td
        {
            width: 30px;
            height: 30px;
        }
 
    </style>
 
    <script>
 
        //au lieu de les definir en dur tu peux récupérer ces variables via une petite question au debut ces variables pour avoir les dimensions de la grille
        let row = 4;
         
        let cols = 7;
 
        let grid = document.createElement("table");
 
        for(i = 0; i < row; i++)
        {
            let newRow = document.createElement("tr");
 
            for(i2 = 0; i2 < cols; i2++)
                newRow.appendChild(document.createElement("td") );
 
            grid.appendChild(newRow);
        }
 
        document.body.appendChild(grid);
 
    </script>
 
</body>