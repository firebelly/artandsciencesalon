
<table class="service-list pricing-table accordian-table">
  <caption class="sr-only">Service Prices and Descriptions</caption>

  <?php 
  $i = 0; // Incrementer for even/odd deduction
  foreach ($services as $service) : 
 
    // Clean the data
    $name = isset($service['name']) ? $service['name'] : '';
    $price = isset($service['price']) ? $service['price'] : '';
    $description = isset($service['description']) ? $service['description'] : '';

    // Increment our counter and get true/false for whether this is an even iteration
    $even = $i++ % 2;

    // Collect any additional classes for row
    $additional_classes = '';
    $additional_classes .= $description ? ' accordian-toggle' : '';
    $additional_classes .= $even ? ' even-row' : ' odd-row';
    ?>

  <tr class="stripey-row leader-row<?= $additional_classes ?>">
    <th class="leader-left stripey-left name" scope="row" <?= $description ? 'rowspan="2"' : '' ?>><span class="leader-text"><?= $name ?> </span></td>
    <th class="sr-only" scope="row">Price</th>
    <td class="leader-right stripey-right price"><span class="leader-text"><?= $price ?></span></td>
  </tr>

  <?php if($description) : ?>
  <tr class="accordian-drawer">
    <th class="sr-only" scope="row">Description</th>
    <td class="description"><?= $description ?></td>
  </tr>
  <?php endif ?>

  <?php endforeach ?>

</table>