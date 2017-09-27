
  <table class="service-list accordian-table salon-color-table">
    <tr class="title-row">
      <th class="sr-only">Service Name</th>
      <th class="price-class">Colorist <span class="sr-only">Price</span></th>
      <th class="price-class">Senior <span class="sr-only">Price</span></th>
      <th class="price-class">Master <span class="sr-only">Price</span></th>
      <th class="price-class">Director <span class="sr-only">Price</span></th>
      <th class="sr-only">Description</th>
    </tr>

    <?php foreach ($services as $service) :
    $name = isset($service['name']) ? $service['name'] : '';
    $colorist_price = isset($service['colorist_price']) ? $service['colorist_price'] : '';
    $senior_price = isset($service['senior_price']) ? $service['senior_price'] : '';
    $master_price = isset($service['master_price']) ? $service['master_price'] : '';
    $director_price = isset($service['director_price']) ? $service['director_price'] : '';
    $description = isset($service['description']) ? $service['description'] : '';

    $has_price = $colorist_price || $senior_price || $master_price || $director_price;
      ?>

    <tr <?= $description ? ' class="accordian-toggle"' : '' ?>>
      <td class="name"><?= $name ?></td>

      <?php if($has_price) : ?>
      <td class="value"><?= $colorist_price ?></td>
      <td class="value"><?= $senior_price ?></td>
      <td class="value"><?= $master_price ?></td>
      <td class="value"><?= $director_price ?></td>
      <?php else : ?>
      <td class="consultation">Quoted By Consultation</td>
      <td class="sr-only">Quoted By Consultation</td>
      <td class="sr-only">Quoted By Consultation</td>
      <td class="sr-only">Quoted By Consultation</td>
      <?php endif ?>

      <?php if($description) : ?>
      <td class="accordian-drawer description"><?= $description ?></td>
      <?php endif ?>

    </tr>
  
    <?php endforeach ?>

</table>