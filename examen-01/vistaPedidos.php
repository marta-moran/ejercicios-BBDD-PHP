<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>
   <div id="container" style="width: 380px;">
      <div id="header">
         <h1>CLIENTESPLUS MVC</h1>
      </div>
      <div id="content">
         <?php if ($cliente === null) { ?>
            <p>No estás registrado</p>
         <?php } else { ?>
            <h3>Bienvenido usuario: <?php echo $cliente->getNombre() ?>. Has entrado <?php echo $cliente->getVeces() ?> veces en nuestra web</h3>
            <?php if (empty($orders)) { ?>
               <p>No existen pedidos para este cliente.</p>
            <?php } else { ?>
               <?php $total = 0; ?>
               <table>
               <?php foreach ($orders as $order) { ?>    
                  <tr>
                     <td><?php echo $order->getProducto() ?></td>
                     <td><?php echo $order->getPrecio() ?></td>
                  </tr>
                  <?php $total += $order->getPrecio(); ?>
               <?php } ?>
                  <tr>
                     <td>TOTAL PEDIDOS</td>
                     <td><?php echo $total ?></td>
                  </tr>
               </table>
            <?php } ?>
         <?php } ?>
      </div>
   </div>
</body>

</html>