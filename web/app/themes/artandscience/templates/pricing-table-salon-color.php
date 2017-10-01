
  <table class="service-list accordian-table salon-color-table">
    <tbody>
      <tr class="title-row">
        <th class="sr-only">Service Name</th>
        <th class="price-class">Colorist <span class="sr-only">Price</span></th>
        <th class="price-class">Senior <span class="sr-only">Price</span></th>
        <th class="price-class">Master <span class="sr-only">Price</span></th>
        <th class="price-class">Director <span class="sr-only">Price</span></th>
      </tr>

      <?php   
      $i = 0; // Incrementer for even/odd deduction
      foreach ($services as $service) :

        $name = isset($service['name']) ? $service['name'] : '';
        $colorist_price = isset($service['colorist_price']) ? $service['colorist_price'] : '';
        $senior_price = isset($service['senior_price']) ? $service['senior_price'] : '';
        $master_price = isset($service['master_price']) ? $service['master_price'] : '';
        $director_price = isset($service['director_price']) ? $service['director_price'] : '';
        $description = isset($service['description']) ? $service['description'] : '';

        $has_price = $colorist_price || $senior_price || $master_price || $director_price;

        // Increment our counter and get true/false for whether this is an even iteration
        $even = $i++ % 2;

        // Collect any additional classes for row
        $additional_classes = '';
        $additional_classes .= $description ? ' accordian-toggle' : '';
        $additional_classes .= $even ? ' even-row' : ' odd-row';
        ?>

        <tr class="service stripey-row<?= $additional_classes ?>">
          <th class="name stripey-left"><?= $name ?></th>

          <?php if($has_price) : ?>

          <td class="value leader-row stripey-right">
            <span class="price-type leader-left">
              <span class="leader-text">Colorist</span>
            </span>
            <span class="price-value leader-right">
              <span class="leader-text"><?= $colorist_price ?></span>
            </span>
          </td>
          <td class="value leader-row stripey-right">
            <span class="price-type leader-left">
              <span class="leader-text">Senior</span>
            </span>
            <span class="price-value leader-right">
              <span class="leader-text"><?= $senior_price ?></span>
            </span>
          </td>
          <td class="value leader-row stripey-right">
            <span class="price-type leader-left">
              <span class="leader-text">Master</span>
            </span>
            <span class="price-value leader-right">
              <span class="leader-text"><?= $master_price ?></span>
            </span>
          </td>
          <td class="value leader-row stripey-right">
            <span class="price-type leader-left">
              <span class="leader-text">Director</span>
            </span>
            <span class="price-value leader-right">
              <span class="leader-text"><?= $director_price ?></span>
            </span>
          </td>

          <?php else : ?>

          <td class="consultation stripey-right">Quoted By Consultation</td>
          <td class="sr-only">Quoted By Consultation</td>
          <td class="sr-only">Quoted By Consultation</td>
          <td class="sr-only">Quoted By Consultation</td>
          <?php endif ?>

        </tr>

        <?php if($description) : ?>  
        <tr class="accordian-drawer">
          <td class="description"><?= $description ?></td>
        </tr>
        <?php endif ?>

      <?php endforeach ?>
  </tbody>
</table>