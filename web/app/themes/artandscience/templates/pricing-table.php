
<table class="service-list accordian-table">
  <tr class="sr-only">
    <th>Name</th>
    <th>Price</th>
    <th>Description</th>
  </tr>

  <?php foreach ($services as $service) : 
    $name = isset($service['name']) ? $service['name'] : '';
    $price = isset($service['price']) ? $service['price'] : '';
    $description = isset($service['description']) ? $service['description'] : '';
    ?>

  <tr <?= $description ? ' class="accordian-toggle"' : '' ?>>
    <td class="name"><?= $name ?></td>
    <td class="value"><?= $price ?></td>

    <?php if($description) : ?>
    <td class="accordian-drawer description"><?= $description ?></td>
    <?php endif ?>

  </tr>

  <?php endforeach ?>

</table>