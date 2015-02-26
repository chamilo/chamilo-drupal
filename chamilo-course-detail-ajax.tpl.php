<div class="cb-inner-container-left"> 
  <ul> 
    <li class="clearfix">
      <strong>Id:</strong>
      <p>
        <?php print $output->id; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Costo:</strong>
      <p>
        <?php print $output->cost; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Lugar:</strong>
      <p>
        <?php print $output->place; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Sesión permite visitantes:</strong>
      <p>
        <?php 
          if (!empty($output->allow_visitors)) {
            print 'Si';
          } 
          else {
            print 'No';
          }
        ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Cantidad de horas lectivas:</strong>
      <p>
        <?php print $output->duration; ?>
      </p>
    </li>
    <li class="clearfix">
      <img src="<?php print $output->banner; ?>" />
    </li>
  </ul> 
</div>
<div class="cb-inner-container-middle">
  <p><?php print $output->as_description; ?></p>
  <a href="<?php print $output->brochure; ?>" class="download-link" donwload>Descargar brochure</a>
</div>
<div class="cb-inner-container-right">
  <?php if ($output->status == -1): ?>
    <a href="<?php print $output->action_url; ?>" class="session-register">Inscribirse</a>
  <?php endif; ?>

  <?php if ($output->status == 0): ?>
    <a href="<?php print $output->action_url; ?>" class="session-virtual-classroom">Ir aula virtual</a>
  <?php endif; ?>

  <?php if ($output->status == 1): ?>
    <p class="session-message">
      <?php print $output->message; ?>
    </p>
  <?php endif; ?>

  <?php if ($output->status == 2): ?>
    <p class="session-message">
      <?php print $output->message; ?>
    </p>
  <?php endif; ?>

  <?php if ($output->status == 3): ?>
    <p class="session-message">
      <?php print $output->message; ?>
    </p>
  <?php endif; ?>

  <?php if ($output->status == 10): ?>
    <p class="session-message">
      <?php print $output->message; ?>
    </p>
  <?php endif; ?>
</div>

